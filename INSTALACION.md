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

## Usuario administrador por defecto

| Campo    | Valor                 |
|----------|-----------------------|
| Email    | admin@clinica.local   |
| Password | password              |

## Paquetes instalados

| Paquete | Uso |
|---------|-----|
| `laravel/socialite` | Login con Google, Facebook, GitHub |
| `barryvdh/laravel-dompdf` | PDF (recetas, reportes) |
| `maatwebsite/excel` | Exportar pacientes/citas a Excel |
| `spatie/laravel-permission` | Roles y permisos |

## Login social

1. Cree aplicaciones OAuth en Google Cloud / Facebook Developers.
2. Complete las variables `GOOGLE_*`, `FACEBOOK_*` en `.env`.
3. URLs de callback: `{APP_URL}/auth/google/callback`, etc.

## API de catálogos (públicos)

- `GET /api/catalog/countries`
- `GET /api/catalog/departments?country_id=1`
- `GET /api/catalog/districts?department_id=1`
- `GET /api/catalog/document-types?for_adults=1`
- `GET /api/catalog/document-types?for_minors=1`
- `GET /api/catalog/kinships`

## Reglas de pacientes (El Salvador)

- **Mayor de edad (18+):** documento tipo DUI (u otro de adulto).
- **Menor de edad:** partida de nacimiento u otro tipo para menores + **responsable** con parentesco y DUI.

## Próximos pasos sugeridos

- Instalar Laravel Breeze o Filament para panel administrativo
- Vistas Blade/Livewire para agenda y expedientes
- `php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"`
