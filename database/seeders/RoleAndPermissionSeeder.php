<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Patient permissions
            'view patients',
            'create patients',
            'edit patients',
            'delete patients',
            
            // Examination permissions
            'view examinations',
            'create examinations',
            'edit examinations',
            'delete examinations',
            
            // Treatment permissions
            'view treatments',
            'create treatments',
            'edit treatments',
            'delete treatments',
            
            // User management
            'manage users',
            'manage roles',
            'view reports',
            'export data',
            'manage nicu'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // NICU Doctor role
        $nicuDoctorRole = Role::create(['name' => 'nicu_doctor']);
        $nicuDoctorRole->givePermissionTo([
            'view patients',
            'create patients',
            'edit patients',
            'view examinations',
            'view treatments',
            'manage nicu',
            'view reports'
        ]);

        // Ophthalmologist role
        $ophthalmologistRole = Role::create(['name' => 'ophthalmologist']);
        $ophthalmologistRole->givePermissionTo([
            'view patients',
            'edit patients',
            'view examinations',
            'create examinations',
            'edit examinations',
            'view treatments',
            'create treatments',
            'edit treatments',
            'view reports'
        ]);

        // Nurse role
        $nurseRole = Role::create(['name' => 'nurse']);
        $nurseRole->givePermissionTo([
            'view patients',
            'create patients',
            'view examinations',
            'view treatments',
            'view reports'
        ]);

        // Resident role
        $residentRole = Role::create(['name' => 'resident']);
        $residentRole->givePermissionTo([
            'view patients',
            'view examinations',
            'create examinations',
            'view treatments',
            'create treatments',
            'view reports'
        ]);
    }
}
