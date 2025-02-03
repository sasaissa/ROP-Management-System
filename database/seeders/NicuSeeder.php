<?php

namespace Database\Seeders;

use App\Models\Nicu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class NicuSeeder extends Seeder
{
    public function run(): void
    {
        // Create NICUs
        $nicus = [
            [
                'name' => 'NICU Unit A',
                'location' => 'East Wing, Floor 3',
                'capacity' => 20,
                'description' => 'Main NICU unit with advanced facilities for premature infants',
                'status' => 'active'
            ],
            [
                'name' => 'NICU Unit B',
                'location' => 'West Wing, Floor 2',
                'capacity' => 15,
                'description' => 'Specialized unit for high-risk infants with dedicated isolation rooms',
                'status' => 'active'
            ],
            [
                'name' => 'NICU Unit C',
                'location' => 'North Wing, Floor 4',
                'capacity' => 12,
                'description' => 'Intermediate care unit for stable premature infants',
                'status' => 'active'
            ],
            [
                'name' => 'NICU Unit D',
                'location' => 'South Wing, Floor 1',
                'capacity' => 8,
                'description' => 'Step-down unit for infants preparing for discharge',
                'status' => 'inactive'
            ]
        ];

        foreach ($nicus as $nicuData) {
            $nicu = Nicu::create($nicuData);
            
            // Randomly assign 2-3 NICU doctors to each NICU
            $doctors = User::role('nicu_doctor')
                         ->inRandomOrder()
                         ->take(rand(2, 3))
                         ->pluck('id');
            
            $nicu->doctors()->attach($doctors);
        }
    }
}
