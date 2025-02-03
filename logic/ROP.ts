import React, { useState, useCallback } from 'react';
import {
  StyleSheet,
  View,
  ScrollView,
  Text,
  TextInput,
  TouchableOpacity,
  Switch,
  Alert,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { Picker } from '@react-native-picker/picker';
import { Ionicons } from '@expo/vector-icons';
import { Colors } from '@/constants/Colors';
import { useColorScheme } from '@/hooks/useColorScheme';
import { Footer } from '@/components/Footer';
import { PatientData, Decision } from '@/types/rop';
import { generateDecision } from '@/lib/rop-decision-logic';

const INITIAL_DATA: PatientData = {
  gestationalAge: 0,
  birthWeight: 0,
  currentPMA: 0,
  chronologicalAge: 0,
  oxygenSupplementation: false,
  respiratoryDistress: false,
  sepsis: false,
  multipleBirth: false,
  ivh: false,
  poorWeightGain: false,
  currentWeight: 0,
  zone: null,
  stage: null,
  plusDisease: null,
  location: null,
  progression: null,
};

const ZONES = ['I', 'II', 'III'] as const;
const STAGES = ['0', '1', '2', '3', '4A', '4B', '5'] as const;
const PLUS_DISEASE = ['none', 'pre-plus', 'plus'] as const;
const LOCATIONS = ['posterior', 'anterior'] as const;
const PROGRESSION = ['stable', 'rapid'] as const;

function createStyles(isDark: boolean) {
  return StyleSheet.create({
    container: {
      flex: 1,
    },
    scrollContent: {
      padding: 16,
    },
    headerSection: {
      alignItems: 'center',
      marginBottom: 24,
    },
    title: {
      fontSize: 24,
      fontWeight: 'bold',
      marginTop: 8,
      color: isDark ? Colors.dark.text : Colors.light.text,
    },
    sectionTitle: {
      fontSize: 18,
      fontWeight: '600',
      marginBottom: 16,
      color: isDark ? Colors.dark.text : Colors.light.text,
    },
    inputSection: {
      backgroundColor: isDark ? Colors.dark.card : Colors.light.card,
      borderRadius: 12,
      padding: 16,
      marginBottom: 24,
    },
    inputGroup: {
      marginBottom: 16,
    },
    label: {
      fontSize: 14,
      marginBottom: 8,
      color: isDark ? Colors.dark.label : Colors.light.label,
    },
    input: {
      borderWidth: 1,
      borderColor: isDark ? Colors.dark.inputBorder : Colors.light.inputBorder,
      borderRadius: 8,
      padding: 12,
      fontSize: 16,
      color: isDark ? Colors.dark.inputText : Colors.light.inputText,
      backgroundColor: isDark ? Colors.dark.inputBackground : Colors.light.inputBackground,
    },
    pickerContainer: {
      borderWidth: 1,
      borderColor: isDark ? Colors.dark.inputBorder : Colors.light.inputBorder,
      borderRadius: 8,
      overflow: 'hidden',
      backgroundColor: isDark ? Colors.dark.inputBackground : Colors.light.inputBackground,
    },
    picker: {
      height: 50,
      color: isDark ? Colors.dark.inputText : Colors.light.inputText,
    },
    switchGroup: {
      flexDirection: 'row',
      justifyContent: 'space-between',
      alignItems: 'center',
      marginBottom: 16,
    },
    switchLabel: {
      fontSize: 14,
      color: isDark ? Colors.dark.label : Colors.light.label,
    },
    buttonGroup: {
      flexDirection: 'row',
      justifyContent: 'space-between',
      marginTop: 24,
    },
    button: {
      flex: 1,
      backgroundColor: Colors.light.tint,
      padding: 16,
      borderRadius: 8,
      marginRight: 8,
    },
    buttonSecondary: {
      flex: 1,
      backgroundColor: 'transparent',
      padding: 16,
      borderRadius: 8,
      marginLeft: 8,
      borderWidth: 1,
      borderColor: isDark ? Colors.dark.inputBorder : Colors.light.inputBorder,
    },
    buttonText: {
      color: '#fff',
      fontSize: 16,
      fontWeight: '600',
      textAlign: 'center',
    },
    buttonTextSecondary: {
      color: isDark ? Colors.dark.text : Colors.light.text,
      fontSize: 16,
      fontWeight: '600',
      textAlign: 'center',
    },
    resultsSection: {
      backgroundColor: isDark ? Colors.dark.card : Colors.light.card,
      borderRadius: 12,
      padding: 16,
    },
    resultItem: {
      flexDirection: 'row',
      justifyContent: 'space-between',
      alignItems: 'center',
      marginBottom: 12,
      paddingBottom: 12,
      borderBottomWidth: 1,
      borderBottomColor: isDark ? Colors.dark.inputBorder : Colors.light.inputBorder,
    },
    resultLabel: {
      fontSize: 14,
      color: isDark ? Colors.dark.label : Colors.light.label,
    },
    resultValue: {
      fontSize: 16,
      fontWeight: '600',
      color: isDark ? Colors.dark.text : Colors.light.text,
    },
    notes: {
      marginTop: 16,
    },
    notesTitle: {
      fontSize: 16,
      fontWeight: '600',
      marginBottom: 8,
      color: isDark ? Colors.dark.text : Colors.light.text,
    },
    note: {
      fontSize: 14,
      color: isDark ? Colors.dark.text : Colors.light.text,
      marginBottom: 4,
      paddingLeft: 8,
    },
    warningText: {
      color: '#EF4444',
      fontSize: 14,
      marginTop: 4,
    },
    locationGroup: {
      marginTop: 8,
      marginLeft: 16,
    },
  });
}

export default function ROPCalculator() {
  const [patientData, setPatientData] = useState<PatientData>(INITIAL_DATA);
  const [decision, setDecision] = useState<Decision | null>(null);
  const colorScheme = useColorScheme();
  const isDark = colorScheme === 'dark';
  const styles = createStyles(isDark);

  const handleInputChange = useCallback((field: keyof PatientData, value: any) => {
    setPatientData(prev => ({ ...prev, [field]: value }));
  }, []);

  const calculateResults = useCallback(() => {
    try {
      // Validate required fields
      if (patientData.gestationalAge <= 0) {
        throw new Error('Please enter a valid gestational age.');
      }
      if (patientData.birthWeight <= 0) {
        throw new Error('Please enter a valid birth weight.');
      }
      if (patientData.currentPMA <= 0) {
        throw new Error('Please enter a valid post-menstrual age.');
      }
      if (patientData.zone === 'II' && !patientData.location) {
        throw new Error('Please specify the location in Zone II (posterior or anterior).');
      }
      if (patientData.zone && !patientData.progression) {
        throw new Error('Please specify the disease progression.');
      }

      const result = generateDecision(patientData);
      setDecision(result);
    } catch (error) {
      if (error instanceof Error) {
        Alert.alert('Input Error', error.message);
      }
    }
  }, [patientData]);

  const resetFields = useCallback(() => {
    setPatientData(INITIAL_DATA);
    setDecision(null);
  }, []);

  return (
    <SafeAreaView style={{ flex: 1 }}>
      <ScrollView style={styles.container} contentContainerStyle={styles.scrollContent}>
        <View style={styles.headerSection}>
          <Ionicons 
            name="eye-outline" 
            size={44} 
            color={isDark ? Colors.dark.icon : Colors.light.icon}
          />
          <Text style={styles.title}>ROP Calculator</Text>
        </View>

        <View style={styles.inputSection}>
          <Text style={styles.sectionTitle}>Patient Information</Text>
          
          <View style={styles.inputGroup}>
            <Text style={styles.label}>Gestational Age (weeks)</Text>
            <TextInput
              style={styles.input}
              value={patientData.gestationalAge.toString()}
              onChangeText={(value) => handleInputChange('gestationalAge', parseFloat(value) || 0)}
              keyboardType="numeric"
              placeholder="Enter gestational age"
              placeholderTextColor={isDark ? Colors.dark.label : Colors.light.label}
            />
          </View>

          <View style={styles.inputGroup}>
            <Text style={styles.label}>Birth Weight (grams)</Text>
            <TextInput
              style={styles.input}
              value={patientData.birthWeight.toString()}
              onChangeText={(value) => handleInputChange('birthWeight', parseFloat(value) || 0)}
              keyboardType="numeric"
              placeholder="Enter birth weight"
              placeholderTextColor={isDark ? Colors.dark.label : Colors.light.label}
            />
          </View>

          <View style={styles.inputGroup}>
            <Text style={styles.label}>Current PMA (weeks)</Text>
            <TextInput
              style={styles.input}
              value={patientData.currentPMA.toString()}
              onChangeText={(value) => handleInputChange('currentPMA', parseFloat(value) || 0)}
              keyboardType="numeric"
              placeholder="Enter current PMA"
              placeholderTextColor={isDark ? Colors.dark.label : Colors.light.label}
            />
          </View>

          <Text style={styles.sectionTitle}>Risk Factors</Text>

          <View style={styles.switchGroup}>
            <Text style={styles.switchLabel}>Oxygen Supplementation</Text>
            <Switch
              value={patientData.oxygenSupplementation}
              onValueChange={(value) => handleInputChange('oxygenSupplementation', value)}
            />
          </View>

          <View style={styles.switchGroup}>
            <Text style={styles.switchLabel}>Respiratory Distress Syndrome</Text>
            <Switch
              value={patientData.respiratoryDistress}
              onValueChange={(value) => handleInputChange('respiratoryDistress', value)}
            />
          </View>

          <View style={styles.switchGroup}>
            <Text style={styles.switchLabel}>Sepsis</Text>
            <Switch
              value={patientData.sepsis}
              onValueChange={(value) => handleInputChange('sepsis', value)}
            />
          </View>

          <View style={styles.switchGroup}>
            <Text style={styles.switchLabel}>Multiple Birth</Text>
            <Switch
              value={patientData.multipleBirth}
              onValueChange={(value) => handleInputChange('multipleBirth', value)}
            />
          </View>

          <View style={styles.switchGroup}>
            <Text style={styles.switchLabel}>Intraventricular Hemorrhage</Text>
            <Switch
              value={patientData.ivh}
              onValueChange={(value) => handleInputChange('ivh', value)}
            />
          </View>

          <View style={styles.switchGroup}>
            <Text style={styles.switchLabel}>Poor Weight Gain</Text>
            <Switch
              value={patientData.poorWeightGain}
              onValueChange={(value) => handleInputChange('poorWeightGain', value)}
            />
          </View>

          <View style={styles.inputGroup}>
            <Text style={styles.label}>Current Weight (grams)</Text>
            <TextInput
              style={styles.input}
              value={patientData.currentWeight.toString()}
              onChangeText={(value) => handleInputChange('currentWeight', parseFloat(value) || 0)}
              keyboardType="numeric"
              placeholder="Enter current weight"
              placeholderTextColor={isDark ? Colors.dark.label : Colors.light.label}
            />
          </View>

          <Text style={styles.sectionTitle}>Examination Findings</Text>

          <View style={styles.inputGroup}>
            <Text style={styles.label}>Zone</Text>
            <View style={styles.pickerContainer}>
              <Picker
                selectedValue={patientData.zone ?? ''}
                onValueChange={(value) => {
                  handleInputChange('zone', value || null);
                  // Reset location if not Zone II
                  if (value !== 'II') {
                    handleInputChange('location', null);
                  }
                }}
                style={styles.picker}
              >
                <Picker.Item label="Select Zone" value="" />
                {ZONES.map((zone) => (
                  <Picker.Item key={zone} label={`Zone ${zone}`} value={zone} />
                ))}
              </Picker>
            </View>
            
            {/* Show location picker only for Zone II */}
            {patientData.zone === 'II' && (
              <View style={styles.locationGroup}>
                <Text style={styles.label}>Location in Zone II</Text>
                <View style={styles.pickerContainer}>
                  <Picker
                    selectedValue={patientData.location ?? ''}
                    onValueChange={(value) => handleInputChange('location', value || null)}
                    style={styles.picker}
                  >
                    <Picker.Item label="Select Location" value="" />
                    {LOCATIONS.map((loc) => (
                      <Picker.Item 
                        key={loc} 
                        label={loc.charAt(0).toUpperCase() + loc.slice(1)} 
                        value={loc}
                      />
                    ))}
                  </Picker>
                </View>
              </View>
            )}
          </View>

          <View style={styles.inputGroup}>
            <Text style={styles.label}>Stage</Text>
            <View style={styles.pickerContainer}>
              <Picker
                selectedValue={patientData.stage ?? ''}
                onValueChange={(value) => handleInputChange('stage', value || null)}
                style={styles.picker}
              >
                <Picker.Item label="Select Stage" value="" />
                {STAGES.map((stage) => (
                  <Picker.Item key={stage} label={`Stage ${stage}`} value={stage} />
                ))}
              </Picker>
            </View>
          </View>

          <View style={styles.inputGroup}>
            <Text style={styles.label}>Plus Disease</Text>
            <View style={styles.pickerContainer}>
              <Picker
                selectedValue={patientData.plusDisease ?? ''}
                onValueChange={(value) => handleInputChange('plusDisease', value || null)}
                style={styles.picker}
              >
                <Picker.Item label="Select Plus Disease Status" value="" />
                {PLUS_DISEASE.map((status) => (
                  <Picker.Item 
                    key={status} 
                    label={status.charAt(0).toUpperCase() + status.slice(1)} 
                    value={status}
                  />
                ))}
              </Picker>
            </View>
          </View>

          <View style={styles.inputGroup}>
            <Text style={styles.label}>Disease Progression</Text>
            <View style={styles.pickerContainer}>
              <Picker
                selectedValue={patientData.progression ?? ''}
                onValueChange={(value) => handleInputChange('progression', value || null)}
                style={styles.picker}
              >
                <Picker.Item label="Select Progression" value="" />
                {PROGRESSION.map((prog) => (
                  <Picker.Item 
                    key={prog} 
                    label={prog.charAt(0).toUpperCase() + prog.slice(1)} 
                    value={prog}
                  />
                ))}
              </Picker>
            </View>
            {patientData.zone && !patientData.progression && (
              <Text style={styles.warningText}>Please select a disease progression.</Text>
            )}
          </View>

          <View style={styles.buttonGroup}>
            <TouchableOpacity 
              style={styles.button}
              onPress={calculateResults}
            >
              <Text style={styles.buttonText}>Calculate</Text>
            </TouchableOpacity>

            <TouchableOpacity 
              style={styles.buttonSecondary}
              onPress={resetFields}
            >
              <Text style={styles.buttonTextSecondary}>Reset</Text>
            </TouchableOpacity>
          </View>
        </View>

        {decision && (
          <View style={styles.resultsSection}>
            <Text style={styles.sectionTitle}>Results</Text>
            
            <View style={styles.resultItem}>
              <Text style={styles.resultLabel}>Risk Level:</Text>
              <Text style={[styles.resultValue, { color: getRiskColor(decision.riskLevel) }]}>
                {decision.riskLevel.toUpperCase()}
              </Text>
            </View>

            <View style={styles.resultItem}>
              <Text style={styles.resultLabel}>Follow-up Schedule:</Text>
              <Text style={styles.resultValue}>{decision.followUpSchedule}</Text>
            </View>

            <View style={styles.resultItem}>
              <Text style={styles.resultLabel}>Treatment:</Text>
              <Text style={styles.resultValue}>{decision.treatmentRecommendation}</Text>
            </View>

            <View style={styles.resultItem}>
              <Text style={styles.resultLabel}>Urgency:</Text>
              <Text style={[styles.resultValue, { color: getUrgencyColor(decision.urgency) }]}>
                {decision.urgency.toUpperCase()}
              </Text>
            </View>

            {decision.notes.length > 0 && (
              <View style={styles.notes}>
                <Text style={styles.notesTitle}>Additional Notes:</Text>
                {decision.notes.map((note, index) => (
                  <Text key={index} style={styles.note}>• {note}</Text>
                ))}
              </View>
            )}
          </View>
        )}
      </ScrollView>
      <Footer />
    </SafeAreaView>
  );
}

function getRiskColor(risk: string): string {
  switch (risk) {
    case 'low': return '#22C55E'; 
    case 'moderate': return '#F59E0B'; 
    case 'high': return '#EF4444'; 
    case 'very-high': return '#DC2626'; 
    default: return Colors.light.text;
  }
}

function getUrgencyColor(urgency: string): string {
  switch (urgency) {
    case 'routine': return '#22C55E'; 
    case 'urgent': return '#F59E0B'; 
    case 'emergency': return '#EF4444'; 
    default: return Colors.light.text;
  }
}
