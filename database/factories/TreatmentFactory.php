<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Treatment>
 */
class TreatmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $patient = \App\Models\Patient::inRandomOrder()->first() ?? \App\Models\Patient::factory()->create();
        $doctor = \App\Models\User::role('ophthalmologist')->inRandomOrder()->first() ?? 
                 \App\Models\User::factory()->create()->assignRole('ophthalmologist');

        return [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'treatment_date' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'treatment_type' => $this->faker->randomElement(['Laser', 'Anti-VEGF', 'Surgery']),
            'eye_treated' => $this->faker->randomElement(['Right', 'Left', 'Both']),
            'notes' => $this->faker->optional()->text(),
            'follow_up_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
