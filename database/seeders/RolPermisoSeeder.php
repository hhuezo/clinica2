<?php

namespace Database\Seeders;

use App\Models\Seguridad\Permission;
use App\Models\Seguridad\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RolPermisoSeeder extends Seeder
{
    public const ROL_ADMIN = 'admin';

    public const ROL_ADMIN_CLINICA = 'admin_clinica';

    public const ROL_USUARIO_CLINICA = 'usuario_clinica';

    public const ROL_ADMIN_SUCURSAL = 'admin_sucursal';

    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permisos = [
            'dashboard.ver',
            'empresas.gestionar',
            'pacientes.ver', 'pacientes.crear', 'pacientes.actualizar', 'pacientes.eliminar', 'pacientes.exportar',
            'citas.ver', 'citas.crear', 'citas.actualizar', 'citas.eliminar',
            'historiales.ver', 'historiales.crear', 'historiales.actualizar',
            'clinicas.gestionar', 'clinicas.ver',
            'sucursales.gestionar', 'sucursales.ver',
            'medicos.gestionar', 'medicos.ver',
            'usuarios.gestionar',
            'roles.gestionar',
            'reportes.pdf', 'reportes.excel',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso, 'guard_name' => 'web']);
        }

        $todos = Permission::all();

        Role::firstOrCreate(['name' => self::ROL_ADMIN, 'guard_name' => 'web'])
            ->syncPermissions($todos);

        Role::firstOrCreate(['name' => self::ROL_ADMIN_CLINICA, 'guard_name' => 'web'])
            ->syncPermissions([
                'dashboard.ver',
                'clinicas.ver',
                'sucursales.gestionar', 'sucursales.ver',
                'medicos.gestionar', 'medicos.ver',
                'usuarios.gestionar',
                'pacientes.ver', 'pacientes.crear', 'pacientes.actualizar', 'pacientes.eliminar', 'pacientes.exportar',
                'citas.ver', 'citas.crear', 'citas.actualizar', 'citas.eliminar',
                'historiales.ver', 'historiales.crear', 'historiales.actualizar',
                'reportes.pdf', 'reportes.excel',
            ]);

        Role::firstOrCreate(['name' => self::ROL_USUARIO_CLINICA, 'guard_name' => 'web'])
            ->syncPermissions([
                'dashboard.ver',
                'clinicas.ver',
                'sucursales.ver',
                'medicos.ver',
                'pacientes.ver', 'pacientes.crear', 'pacientes.actualizar',
                'citas.ver', 'citas.crear', 'citas.actualizar',
                'historiales.ver', 'historiales.crear', 'historiales.actualizar',
                'reportes.pdf',
            ]);

        Role::firstOrCreate(['name' => self::ROL_ADMIN_SUCURSAL, 'guard_name' => 'web'])
            ->syncPermissions([
                'dashboard.ver',
                'sucursales.ver',
                'medicos.ver',
                'pacientes.ver', 'pacientes.crear', 'pacientes.actualizar', 'pacientes.eliminar', 'pacientes.exportar',
                'citas.ver', 'citas.crear', 'citas.actualizar', 'citas.eliminar',
                'historiales.ver', 'historiales.crear', 'historiales.actualizar',
                'reportes.pdf', 'reportes.excel',
            ]);
    }
}
