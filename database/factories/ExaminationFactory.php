<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Examination>
 */
class ExaminationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $patient = \App\Models\Patient::inRandomOrder()->first() ?? \App\Models\Patient::factory()->create();
        $examiner = \App\Models\User::role('ophthalmologist')->inRandomOrder()->first() ?? 
                   \App\Models\User::factory()->create()->assignRole('ophthalmologist');

        $examinationDate = $this->faker->dateTimeBetween('-3 months', '+1 month');
        $status = $examinationDate > now() ? 'scheduled' : 'completed';

        return [
            'patient_id' => $patient->id,
            'examiner_id' => $examiner->id,
            'examination_date' => $examinationDate,
            'right_eye_stage' => $this->faker->randomElement(['Stage 1', 'Stage 2', 'Stage 3', 'Stage 4', 'Stage 5']),
            'left_eye_stage' => $this->faker->randomElement(['Stage 1', 'Stage 2', 'Stage 3', 'Stage 4', 'Stage 5']),
            'right_eye_zone' => $this->faker->randomElement(['Zone I', 'Zone II', 'Zone III']),
            'left_eye_zone' => $this->faker->randomElement(['Zone I', 'Zone II', 'Zone III']),
            'notes' => $this->faker->optional()->text(),
            'status' => $status,
            'follow_up_date' => $status === 'completed' ? 
                $this->faker->dateTimeBetween($examinationDate, '+2 weeks') : null,
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
