# Clínica — Sistema de citas y expedientes

## Requisitos

- PHP 8.2+
- Composer
- MySQL o MariaDB (XAMPP)
- Node.js (opcional, para assets)

## Instalación

```bash
cd c:\xampp\htdocs\clinica
composer install
copy .env.example .env
php artisan key:generate
```

Configure en `.env` la base de datos MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clinica
DB_USERNAME=root
DB_PASSWORD=
```

Cree la base de datos `clinica` en phpMyAdmin y ejecute:

```bash
php artisan migrate --seed
```

## Usuarios de demostración (contraseña: `password`)

| Rol | Email |
|-----|-------|
| admin | admin@clinica.local |
| admin_clinica | admin.clinica@saludtotal.sv |
| usuario_clinica | usuario.clinica@saludtotal.sv |
| admin_sucursal | admin.sucursal@saludtotal.sv |

Datos de organización: empresa **Salud Total SV**, clínica **Clínica Salud Total**, sucursales **Centro** y **Santa Tecla**.

## Paquetes instalados

| Paquete | Uso |
|---------|-----|
| `laravel/socialite` | Login con Google, Facebook, GitHub |
| `barryvdh/laravel-dompdf` | PDF (recetas, reportes) |
| `maatwebsite/excel` | Exportar pacientes/citas a Excel |
| `spatie/laravel-permission` | Roles y permisos (`App\Models\Seguridad\Rol`, `Permiso`) |

## Login social

1. Cree aplicaciones OAuth en Google Cloud / Facebook Developers.
2. Complete las variables `GOOGLE_*`, `FACEBOOK_*` en `.env`.
3. URLs de callback: `{APP_URL}/auth/google/callback`, etc.

## Arquitectura

Proyecto **monolito Laravel**: rutas en `routes/web.php`, vistas Blade, autenticación con Breeze. La lógica de dominio vive en modelos (`app/Models`) y servicios (`app/Services`); los controladores web se irán agregando junto con las vistas.

## Roles y permisos

Estructura de modelos:

| Carpeta | Modelos |
|---------|---------|
| `App\Models\Seguridad` | `User`, `Role`, `Permission` |
| `App\Models\Catalogo` | `Pais`, `Departamento`, `Distrito`, `TipoDocumento`, `Parentesco` |
| `App\Models` | `Empresa`, `Clinica`, `Sucursal`, `Paciente`, `Cita`, `Medico`, etc. |

Spatie usa tablas sin cambiar: `roles`, `permissions`, etc.

Roles por defecto: `admin`, `admin_clinica`, `usuario_clinica`, `admin_sucursal`. Permisos con notación `recurso.accion` (ej. `pacientes.crear`, `citas.ver`).

En rutas o controladores:

```php
Route::get('/pacientes', ...)->middleware('permission:pacientes.ver');
Route::get('/admin', ...)->middleware('role:admin');
```

En Blade: `@can('pacientes.crear')` o `@role('administrador')`.

## Reglas de pacientes (El Salvador)

- **Mayor de edad (18+):** documento tipo DUI (u otro de adulto).
- **Menor de edad:** partida de nacimiento u otro tipo para menores + **responsable** con parentesco y DUI.

## Próximos pasos sugeridos

- Controladores y rutas web para pacientes, citas y clínicas (vistas Blade)
- Panel administrativo (Breeze ya instalado o Filament)
- `php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"`
