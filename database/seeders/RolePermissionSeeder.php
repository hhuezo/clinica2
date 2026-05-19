<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'dashboard.view',
            'patients.view', 'patients.create', 'patients.update', 'patients.delete', 'patients.export',
            'appointments.view', 'appointments.create', 'appointments.update', 'appointments.delete',
            'medical-records.view', 'medical-records.create', 'medical-records.update',
            'clinics.manage', 'branches.manage', 'doctors.manage',
            'users.manage', 'roles.manage',
            'reports.pdf', 'reports.excel',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'administrador', 'guard_name' => 'web']);
        $admin->syncPermissions(Permission::all());

        $doctor = Role::firstOrCreate(['name' => 'doctor', 'guard_name' => 'web']);
        $doctor->syncPermissions([
            'dashboard.view',
            'patients.view', 'patients.update',
            'appointments.view', 'appointments.update',
            'medical-records.view', 'medical-records.create', 'medical-records.update',
            'reports.pdf',
        ]);

        $reception = Role::firstOrCreate(['name' => 'recepcion', 'guard_name' => 'web']);
        $reception->syncPermissions([
            'dashboard.view',
            'patients.view', 'patients.create', 'patients.update', 'patients.export',
            'appointments.view', 'appointments.create', 'appointments.update', 'appointments.delete',
            'reports.excel',
        ]);
    }
}
