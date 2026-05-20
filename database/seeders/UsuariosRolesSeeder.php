<?php

namespace Database\Seeders;

use App\Models\Catalogo\Distrito;
use App\Models\Clinica;
use App\Models\Empresa;
use App\Models\Seguridad\User;
use App\Models\Sucursal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosRolesSeeder extends Seeder
{
    public const PASSWORD_DEMO = 'password';

    public function run(): void
    {
        DB::transaction(function () {
            $distrito = Distrito::find(110); // San Salvador, dept. 06

            $empresa = Empresa::updateOrCreate(
                ['nit' => '0614-010101-101-1'],
                [
                    'nombre' => 'Salud Total SV',
                    'razon_social' => 'Salud Total de El Salvador, S.A. de C.V.',
                    'telefono' => '+503 2222-0000',
                    'correo' => 'contacto@saludtotal.sv',
                    'direccion' => 'Colonia Escalón, San Salvador',
                    'departamento_id' => $distrito?->departamento_id,
                    'distrito_id' => $distrito?->id,
                    'activo' => true,
                ]
            );

            $clinica = Clinica::updateOrCreate(
                [
                    'empresa_id' => $empresa->id,
                    'nombre' => 'Clínica Salud Total',
                ],
                [
                    'razon_social' => 'Clínica Salud Total Centro',
                    'nit' => '0614-020202-202-2',
                    'telefono' => '+503 2222-1111',
                    'correo' => 'centro@saludtotal.sv',
                    'direccion' => 'Av. La Revolución, San Salvador',
                    'departamento_id' => $distrito?->departamento_id,
                    'distrito_id' => $distrito?->id,
                    'activo' => true,
                ]
            );

            $sucursalPrincipal = Sucursal::updateOrCreate(
                [
                    'clinica_id' => $clinica->id,
                    'codigo' => 'SUC-001',
                ],
                [
                    'nombre' => 'Sucursal Centro',
                    'telefono' => '+503 2222-2222',
                    'correo' => 'centro@saludtotal.sv',
                    'direccion' => 'Av. La Revolución #123, San Salvador',
                    'departamento_id' => $distrito?->departamento_id,
                    'distrito_id' => $distrito?->id,
                    'es_principal' => true,
                    'activo' => true,
                ]
            );

            Sucursal::updateOrCreate(
                [
                    'clinica_id' => $clinica->id,
                    'codigo' => 'SUC-002',
                ],
                [
                    'nombre' => 'Sucursal Santa Tecla',
                    'telefono' => '+503 2222-3333',
                    'correo' => 'santatecla@saludtotal.sv',
                    'direccion' => 'Calle 14 de diciembre, Santa Tecla',
                    'es_principal' => false,
                    'activo' => true,
                ]
            );

            $usuarios = [
                [
                    'email' => 'admin@clinica.local',
                    'name' => 'Administrador del sistema',
                    'rol' => RolPermisoSeeder::ROL_ADMIN,
                    'empresa_id' => null,
                    'clinica_id' => null,
                    'sucursal_id' => null,
                ],
                [
                    'email' => 'admin.clinica@saludtotal.sv',
                    'name' => 'Admin Clínica Salud Total',
                    'rol' => RolPermisoSeeder::ROL_ADMIN_CLINICA,
                    'empresa_id' => $empresa->id,
                    'clinica_id' => $clinica->id,
                    'sucursal_id' => null,
                ],
                [
                    'email' => 'usuario.clinica@saludtotal.sv',
                    'name' => 'Usuario Clínica Salud Total',
                    'rol' => RolPermisoSeeder::ROL_USUARIO_CLINICA,
                    'empresa_id' => $empresa->id,
                    'clinica_id' => $clinica->id,
                    'sucursal_id' => null,
                ],
                [
                    'email' => 'admin.sucursal@saludtotal.sv',
                    'name' => 'Admin Sucursal Centro',
                    'rol' => RolPermisoSeeder::ROL_ADMIN_SUCURSAL,
                    'empresa_id' => $empresa->id,
                    'clinica_id' => $clinica->id,
                    'sucursal_id' => $sucursalPrincipal->id,
                ],
            ];

            foreach ($usuarios as $datos) {
                $rol = $datos['rol'];
                unset($datos['rol']);

                $user = User::updateOrCreate(
                    ['email' => $datos['email']],
                    [
                        ...$datos,
                        'password' => Hash::make(self::PASSWORD_DEMO),
                        'activo' => true,
                        'email_verified_at' => now(),
                    ]
                );

                $user->syncRoles([$rol]);
            }
        });
    }
}
