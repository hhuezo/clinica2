<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Models\Seguridad\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\PermissionRegistrar;

class PermisoController extends Controller
{
    public function index(): View
    {
        $permisos = Permission::query()
            ->where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('seguridad.permiso.index', compact('permisos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ], [
            'name.required' => 'El nombre del permiso es obligatorio.',
            'name.unique' => 'Ya existe un permiso con este nombre.',
        ]);

        Permission::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('success', 'Permiso creado correctamente.');
    }

    public function update(Request $request, Permission $permiso): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($permiso->id)],
        ], [
            'name.required' => 'El nombre del permiso es obligatorio.',
            'name.unique' => 'Ya existe un permiso con este nombre.',
        ]);

        $permiso->update(['name' => $validated['name']]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('success', 'Permiso actualizado correctamente.');
    }

    public function destroy(Permission $permiso): RedirectResponse
    {
        if ($permiso->roles()->exists()) {
            return back()->with('error', 'No se puede eliminar un permiso asignado a roles.');
        }

        $permiso->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('success', 'Permiso eliminado correctamente.');
    }
}
