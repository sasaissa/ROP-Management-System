<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        // Create ophthalmologists
        $ophthalmologists = [
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'phone' => '555-0101',
                'specialty' => 'Ophthalmology',
                'license_number' => 'OPH001'
            ],
            [
                'name' => 'Dr. Michael Chen',
                'email' => 'michael.chen@example.com',
                'phone' => '555-0102',
                'specialty' => 'Ophthalmology',
                'license_number' => 'OPH002'
            ],
            [
                'name' => 'Dr. Emily Rodriguez',
                'email' => 'emily.rodriguez@example.com',
                'phone' => '555-0103',
                'specialty' => 'Ophthalmology',
                'license_number' => 'OPH003'
            ]
        ];

        foreach ($ophthalmologists as $doctorData) {
            $doctor = Doctor::create($doctorData);
            $doctor->assignRole('ophthalmologist');
        }
    }
}
