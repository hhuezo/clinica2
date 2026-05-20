<?php

use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Organizacion\ClinicaController;
use App\Http\Controllers\Organizacion\EmpresaController;
use App\Http\Controllers\Organizacion\MedicoController;
use App\Http\Controllers\Organizacion\SucursalController;
use App\Http\Controllers\Seguridad\PermisoController;
use App\Http\Controllers\Seguridad\RolController;
use App\Http\Controllers\Seguridad\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('password.change');
});

Route::middleware(['auth', 'verified', 'permission:dashboard.ver'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->prefix('seguridad')->name('seguridad.')->group(function () {
    Route::middleware('permission:usuarios.gestionar')->group(function () {
        Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::put('usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
        Route::post('usuarios/{usuario}/roles/{rol}/toggle', [UsuarioController::class, 'toggleRol'])->name('usuarios.roles.toggle');
    });

    Route::middleware('permission:roles.gestionar')->group(function () {
        Route::get('roles', [RolController::class, 'index'])->name('roles.index');
        Route::post('roles', [RolController::class, 'store'])->name('roles.store');
        Route::put('roles/{rol}', [RolController::class, 'update'])->name('roles.update');
        Route::delete('roles/{rol}', [RolController::class, 'destroy'])->name('roles.destroy');
        Route::post('roles/{rol}/permisos/{permiso}/toggle', [RolController::class, 'togglePermiso'])->name('roles.permisos.toggle');

        Route::get('permisos', [PermisoController::class, 'index'])->name('permisos.index');
        Route::post('permisos', [PermisoController::class, 'store'])->name('permisos.store');
        Route::put('permisos/{permiso}', [PermisoController::class, 'update'])->name('permisos.update');
        Route::delete('permisos/{permiso}', [PermisoController::class, 'destroy'])->name('permisos.destroy');
    });
});

Route::middleware(['auth', 'verified'])->prefix('organizacion')->name('organizacion.')->group(function () {
    Route::middleware('permission:empresas.gestionar')->group(function () {
        Route::get('empresas', [EmpresaController::class, 'index'])->name('empresas.index');
        Route::post('empresas', [EmpresaController::class, 'store'])->name('empresas.store');
        Route::put('empresas/{empresa}', [EmpresaController::class, 'update'])->name('empresas.update');
        Route::delete('empresas/{empresa}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');
    });

    Route::middleware('permission:clinicas.ver|clinicas.gestionar')->group(function () {
        Route::get('clinicas', [ClinicaController::class, 'index'])->name('clinicas.index');
    });

    Route::middleware('permission:clinicas.gestionar')->group(function () {
        Route::post('clinicas', [ClinicaController::class, 'store'])->name('clinicas.store');
        Route::put('clinicas/{clinica}', [ClinicaController::class, 'update'])->name('clinicas.update');
        Route::delete('clinicas/{clinica}', [ClinicaController::class, 'destroy'])->name('clinicas.destroy');
    });

    Route::middleware('permission:sucursales.ver|sucursales.gestionar')->group(function () {
        Route::get('sucursales', [SucursalController::class, 'index'])->name('sucursales.index');
    });

    Route::middleware('permission:sucursales.gestionar')->group(function () {
        Route::post('sucursales', [SucursalController::class, 'store'])->name('sucursales.store');
        Route::put('sucursales/{sucursal}', [SucursalController::class, 'update'])->name('sucursales.update');
        Route::delete('sucursales/{sucursal}', [SucursalController::class, 'destroy'])->name('sucursales.destroy');
        Route::post('sucursales/{sucursal}/medicos/{medico}/toggle', [SucursalController::class, 'toggleMedico'])->name('sucursales.medicos.toggle');
    });

    Route::middleware('permission:medicos.ver|medicos.gestionar')->group(function () {
        Route::get('medicos', [MedicoController::class, 'index'])->name('medicos.index');
    });

    Route::middleware('permission:medicos.gestionar')->group(function () {
        Route::post('medicos', [MedicoController::class, 'store'])->name('medicos.store');
        Route::put('medicos/{medico}', [MedicoController::class, 'update'])->name('medicos.update');
        Route::delete('medicos/{medico}', [MedicoController::class, 'destroy'])->name('medicos.destroy');
        Route::post('medicos/{medico}/sucursales/{sucursal}/toggle', [MedicoController::class, 'toggleSucursal'])->name('medicos.sucursales.toggle');
    });
});

Route::prefix('auth')->group(function () {
    Route::get('{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('social.redirect');
    Route::get('{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');
});

require __DIR__.'/auth.php';
