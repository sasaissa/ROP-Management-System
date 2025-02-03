<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement(['male', 'female', 'other']);
        $dob = $this->faker->dateTimeBetween('-1 year', '-1 day');
        
        return [
            'medical_record_number' => 'MRN' . $this->faker->unique()->numberBetween(10000, 99999),
            'first_name' => $this->faker->firstName($gender === 'other' ? null : $gender),
            'last_name' => $this->faker->lastName(),
            'date_of_birth' => $dob,
            'gestational_age' => $this->faker->numberBetween(24, 36),
            'birth_weight' => $this->faker->numberBetween(500, 2500),
            'gender' => $gender,
            'nicu_location' => $this->faker->randomElement(['NICU-A', 'NICU-B']),
            'medical_history' => [
                'respiratory_distress_syndrome' => $this->faker->boolean(60),
                'sepsis' => $this->faker->boolean(30),
                'blood_transfusion' => $this->faker->boolean(40),
                'patent_ductus_arteriosus' => $this->faker->boolean(25),
                'intraventricular_hemorrhage' => $this->faker->boolean(20),
                'necrotizing_enterocolitis' => $this->faker->boolean(15),
                'mechanical_ventilation' => $this->faker->boolean(50)
            ],
            'medical_history_notes' => $this->faker->optional(0.7)->sentence(),
            'parent_contact' => $this->faker->phoneNumber(),
            'multiple_birth_status' => $this->faker->randomElement(['single', 'twin', 'triplet']),
            'head_circumference' => $this->faker->numberBetween(20, 35),
            'mode_of_delivery' => $this->faker->randomElement(['vaginal', 'c-section']),
            'antenatal_steroids_received' => $this->faker->boolean(),
            'maternal_complications' => $this->faker->sentence(),
            'days_on_oxygen' => $this->faker->numberBetween(0, 30),
            'days_on_ventilation' => $this->faker->numberBetween(0, 30),
            'highest_fio2_received' => $this->faker->randomFloat(2, 0.21, 1.00),
            'surfactant_therapy' => $this->faker->randomElement(['none', 'single_dose', 'multiple_doses']),
            'weight_at_examination' => $this->faker->numberBetween(500, 4000),
            'post_menstrual_age' => $this->faker->randomFloat(1, 24, 40),
            'admission_date' => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}
