import { PatientData, Decision } from "@/types/rop";

interface RiskScore {
  score: number;
  factors: string[];
}

interface TreatmentCriteria {
  requiresImmediate: boolean;
  requiresConsideration: boolean;
  reasons: string[];
}

export function calculateRiskScore(data: PatientData): RiskScore {
  let score = 0;
  const factors: string[] = [];

  // Birth weight risk assessment
  if (data.birthWeight < 750) {
    score += 4;
    factors.push("Extremely low birth weight (<750g)");
  } else if (data.birthWeight < 1000) {
    score += 3;
    factors.push("Very low birth weight (<1000g)");
  } else if (data.birthWeight < 1500) {
    score += 2;
    factors.push("Low birth weight (<1500g)");
  }

  // Gestational age risk assessment
  if (data.gestationalAge < 26) {
    score += 4;
    factors.push("Extremely premature (<26 weeks)");
  } else if (data.gestationalAge < 28) {
    score += 3;
    factors.push("Very premature (<28 weeks)");
  } else if (data.gestationalAge < 32) {
    score += 2;
    factors.push("Premature (<32 weeks)");
  }

  // Additional risk factors
  if (data.oxygenSupplementation) {
    score += 2;
    factors.push("Oxygen supplementation");
  }
  if (data.respiratoryDistress) {
    score += 1;
    factors.push("Respiratory distress syndrome");
  }
  if (data.sepsis) {
    score += 1;
    factors.push("Sepsis");
  }
  if (data.multipleBirth) {
    score += 1;
    factors.push("Multiple birth");
  }
  if (data.ivh) {
    score += 1;
    factors.push("Intraventricular hemorrhage");
  }
  if (data.poorWeightGain) {
    score += 2;
    factors.push("Poor postnatal weight gain");
  }

  return { score, factors };
}

export function evaluateTreatmentCriteria(data: PatientData): TreatmentCriteria {
  let requiresImmediate = false;
  let requiresConsideration = false;
  let reasons: string[] = [];

  // Check for Aggressive ROP (A-ROP)
  if ((data.zone === 'I' || (data.zone === 'II' && data.location === 'posterior')) &&
      data.plusDisease === 'plus' &&
      data.progression === 'rapid') {
    requiresImmediate = true;
    reasons.push("Aggressive ROP (A-ROP) - requires immediate intervention");
  }

  // Standard treatment criteria based on ICROP3
  if (data.zone === 'I' && data.plusDisease === 'plus') {
    requiresImmediate = true;
    reasons.push("Zone I with plus disease");
  }
  if (data.zone === 'I' && data.stage === '3') {
    requiresImmediate = true;
    reasons.push("Zone I stage 3 ROP");
  }
  if (data.zone === 'II' && 
      (data.stage === '2' || data.stage === '3') && 
      data.plusDisease === 'plus') {
    requiresImmediate = true;
    reasons.push("Zone II stage 2 or 3 with plus disease");
  }

  // Posterior Zone II considerations
  if (data.zone === 'II' && 
      data.location === 'posterior') {
    if (data.plusDisease === 'plus' || data.stage === '3') {
      requiresImmediate = true;
      reasons.push("Posterior Zone II with plus disease or stage 3");
    } else if (data.plusDisease === 'pre-plus') {
      requiresConsideration = true;
      reasons.push("Posterior Zone II with pre-plus disease - requires close monitoring");
    }
  }

  // Plus disease spectrum consideration
  if (data.plusDisease === 'pre-plus' && data.progression === 'rapid') {
    requiresConsideration = true;
    reasons.push("Pre-plus disease with rapid progression - may develop plus disease");
  }

  return { requiresImmediate, requiresConsideration, reasons };
}

export function determineFollowUpSchedule(data: PatientData, riskScore: number): string {
  // Calculate if this is initial screening
  const isInitialScreening = !data.zone && !data.stage && !data.plusDisease;
  
  // Initial screening timing based on ICROP3
  if (isInitialScreening) {
    if (data.gestationalAge < 28) {
      return "Initial exam at 31 weeks PMA";
    } else {
      return "Initial exam at 4 weeks after birth";
    }
  }

  // A-ROP or critical findings requiring immediate action
  if ((data.zone === 'I' || (data.zone === 'II' && data.location === 'posterior')) &&
      (data.plusDisease === 'plus' || data.progression === 'rapid')) {
    return "Examination required within 24-48 hours";
  }

  // Urgent monitoring cases
  if (data.plusDisease === 'pre-plus' && data.progression === 'rapid') {
    return "Examinations every 2-3 days";
  }
  if (data.zone === 'II' && data.location === 'posterior' && data.plusDisease === 'pre-plus') {
    return "Examinations every 3-4 days";
  }

  // High risk weekly monitoring
  if (
    data.zone === 'I' ||
    (data.zone === 'II' && data.location === 'posterior') ||
    data.plusDisease === 'pre-plus' ||
    data.plusDisease === 'plus' ||
    data.stage === '3'
  ) {
    return "Weekly examinations required";
  }

  // Biweekly examinations criteria
  if (
    (data.zone === 'II' && data.location === 'anterior') ||
    (data.stage === '2' && data.plusDisease === 'none')
  ) {
    return "Examinations every 2 weeks";
  }

  // Based on risk score
  if (riskScore >= 6) {
    return "Weekly examinations recommended due to high risk factors";
  }

  // Default follow-up
  if (data.currentPMA < 36) {
    return "Examinations every 2 weeks until 36 weeks PMA";
  }

  return "Examinations every 2 weeks, adjust based on findings";
}

export function generateDecision(data: PatientData): Decision {
  const { score: riskScore, factors: riskFactors } = calculateRiskScore(data);
  const treatmentCriteria = evaluateTreatmentCriteria(data);
  const followUpSchedule = determineFollowUpSchedule(data, riskScore);

  // Determine risk level
  let riskLevel: 'low' | 'moderate' | 'high' | 'very-high' = 'low';
  if (riskScore >= 8) riskLevel = 'very-high';
  else if (riskScore >= 6) riskLevel = 'high';
  else if (riskScore >= 4) riskLevel = 'moderate';

  // Determine urgency
  let urgency: 'routine' | 'urgent' | 'emergency' = 'routine';
  if (treatmentCriteria.requiresImmediate) urgency = 'emergency';
  else if (treatmentCriteria.requiresConsideration) urgency = 'urgent';

  // Generate treatment recommendation based on ICROP3
  let treatmentRecommendation = "Continue screening according to schedule.";
  
  if (treatmentCriteria.requiresImmediate) {
    if ((data.zone === 'I' || (data.zone === 'II' && data.location === 'posterior')) &&
        data.plusDisease === 'plus' &&
        data.progression === 'rapid') {
      treatmentRecommendation = "EMERGENCY: Immediate treatment required for Aggressive ROP (A-ROP). Anti-VEGF therapy is preferred for Zone I or posterior Zone II disease.";
    } else if (data.zone === 'I') {
      if (data.plusDisease === 'plus') {
        treatmentRecommendation = "EMERGENCY: Immediate treatment required for Zone I plus disease. Anti-VEGF therapy is preferred for Zone I disease.";
      } else if (data.stage === '3') {
        treatmentRecommendation = "EMERGENCY: Immediate treatment required for Zone I stage 3. Anti-VEGF therapy is preferred for Zone I disease.";
      }
    } else if (data.zone === 'II') {
      if (data.location === 'posterior' && (data.plusDisease === 'plus' || data.stage === '3')) {
        treatmentRecommendation = "EMERGENCY: Immediate treatment required for posterior Zone II disease. Consider anti-VEGF therapy or laser photocoagulation based on disease characteristics.";
      } else if ((data.stage === '2' || data.stage === '3') && data.plusDisease === 'plus') {
        treatmentRecommendation = "EMERGENCY: Immediate treatment required. Laser photocoagulation is standard treatment for Zone II disease with plus disease.";
      }
    }
  } else if (treatmentCriteria.requiresConsideration) {
    if (data.zone === 'II' && data.location === 'posterior' && data.plusDisease === 'pre-plus') {
      treatmentRecommendation = "URGENT: Close monitoring required for posterior Zone II with pre-plus disease. Consider treatment if progression noted. Monitor every 3-4 days.";
    } else if (data.plusDisease === 'pre-plus' && data.progression === 'rapid') {
      treatmentRecommendation = "URGENT: Close monitoring required for pre-plus disease with rapid progression. Consider early treatment if continued progression. Monitor every 2-3 days.";
    }
  } else if (data.stage === '1' || data.stage === '2') {
    treatmentRecommendation = "Continue screening. Treatment not indicated for Stage 1-2 without plus disease. Monitor for progression.";
  }

  // Compile notes
  const notes: string[] = [
    ...riskFactors,
    ...treatmentCriteria.reasons
  ];

  // Add specific guidance based on findings
  if (data.zone === 'I') {
    notes.push("Zone I disease has high risk of progression and requires careful monitoring");
  }
  if (data.plusDisease === 'pre-plus') {
    notes.push("Pre-plus disease: monitor closely for progression to plus disease");
  }
  if (data.progression === 'rapid') {
    notes.push("Rapid progression indicates increased risk and may require more frequent monitoring");
  }
  if (data.stage === '4A' || data.stage === '4B' || data.stage === '5') {
    notes.push("Late-stage ROP: urgent vitreoretinal surgical consultation required");
  }

  return {
    riskLevel,
    followUpSchedule,
    treatmentRecommendation,
    urgency,
    notes
  };
}
