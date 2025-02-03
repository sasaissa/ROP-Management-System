<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Examination;
use App\Models\Treatment;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            NicuSeeder::class,
            DoctorSeeder::class,
        ]);

        // Create admin user
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $adminUser->assignRole('admin');

        // Get all doctors
        $doctors = Doctor::all();
        if ($doctors->isEmpty()) {
            throw new \Exception('No doctors found in the database. Please ensure DoctorSeeder has run successfully.');
        }

        // Create patients with varying data
        Patient::factory(20)->create()->each(function ($patient) use ($doctors) {
            // Assign a random doctor to the patient
            $patient->doctor_id = $doctors->random()->id;
            $patient->save();

            // Create 2-4 examinations for each patient
            $numExaminations = rand(2, 4);
            
            for ($i = 0; $i < $numExaminations; $i++) {
                $examination = Examination::create([
                    'patient_id' => $patient->id,
                    'examiner_id' => $doctors->random()->id,
                    'examination_date' => Carbon::now()->subDays(rand(0, 30)),
                    'right_eye_zone' => $this->randomZone(),
                    'right_eye_stage' => $this->randomStage(),
                    'right_eye_plus' => $this->randomPlusDisease(),
                    'right_eye_clock_hours' => $this->randomClockHours(),
                    'right_eye_ap_rop' => (bool)rand(0, 1),
                    'right_eye_regression_status' => $this->randomRegressionStatus(),
                    'right_eye_par' => rand(0, 1) ? 'Temporal region' : null,
                    'left_eye_zone' => $this->randomZone(),
                    'left_eye_stage' => $this->randomStage(),
                    'left_eye_plus' => $this->randomPlusDisease(),
                    'left_eye_clock_hours' => $this->randomClockHours(),
                    'left_eye_ap_rop' => (bool)rand(0, 1),
                    'left_eye_regression_status' => $this->randomRegressionStatus(),
                    'left_eye_par' => rand(0, 1) ? 'Temporal region' : null,
                    'notes' => $this->randomNotes(),
                ]);
            }
        });

        // Create treatments for each patient
        foreach (Patient::all() as $patient) {
            // Create 1-3 treatments for each patient
            $treatmentCount = rand(1, 3);
            for ($i = 0; $i < $treatmentCount; $i++) {
                Treatment::create([
                    'patient_id' => $patient->id,
                    'examiner_id' => $doctors->random()->id,
                    'treating_doctor_id' => $doctors->random()->id,
                    'treatment_date' => Carbon::now()->subDays(rand(0, 30)),
                    'treatment_type' => rand(0, 1) ? 'Laser' : 'Surgery',
                    'eye_treated' => rand(0, 1) ? 'Right' : 'Left',
                    'notes' => rand(0, 1) ? 'Follow-up required' : null,
                    'follow_up_date' => Carbon::now()->addDays(rand(25, 35)),
                    'created_at' => Carbon::now()->subDays(rand(60, 120)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 60))
                ]);
            }
        }
    }

    private function randomZone(): string
    {
        return collect(['I', 'posterior II', 'II', 'III'])->random();
    }

    private function randomStage(): string
    {
        return collect(['1', '2', '3', '4A', '4B', '5A', '5B', '5C'])->random();
    }

    private function randomPlusDisease(): string
    {
        return collect(['none', 'pre-plus', 'plus'])->random();
    }

    private function randomClockHours(): int
    {
        return rand(1, 12);
    }

    private function randomRegressionStatus(): string
    {
        return collect(['none', 'partial', 'complete'])->random();
    }

    private function randomNotes(): ?string
    {
        $notes = [
            'Patient responded well to examination',
            'Follow-up recommended in 2 weeks',
            'Signs of improvement noted',
            'Continued monitoring required',
            null
        ];
        return collect($notes)->random();
    }
}
