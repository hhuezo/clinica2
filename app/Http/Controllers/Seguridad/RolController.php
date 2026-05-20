<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Models\Seguridad\Permission;
use App\Models\Seguridad\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\PermissionRegistrar;

class RolController extends Controller
{
    public function index(): View
    {
        $roles = Role::query()
            ->where('guard_name', 'web')
            ->with('permissions')
            ->withCount('users')
            ->orderBy('name')
            ->get();

        $permisos = Permission::query()
            ->where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('seguridad.rol.index', compact('roles', 'permisos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'Ya existe un rol con este nombre.',
        ]);

        Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('success', 'Rol creado correctamente. Asigne permisos desde el detalle.');
    }

    public function update(Request $request, Role $rol): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($rol->id)],
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'Ya existe un rol con este nombre.',
        ]);

        $rol->update(['name' => $validated['name']]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('success', 'Rol actualizado correctamente.');
    }

    public function togglePermiso(Request $request, Role $rol, Permission $permiso): JsonResponse
    {
        $request->validate(['enabled' => ['required', 'boolean']]);

        if ($request->boolean('enabled')) {
            $rol->givePermissionTo($permiso);
            $message = "Permiso «{$permiso->name}» asignado.";
        } else {
            $rol->revokePermissionTo($permiso);
            $message = "Permiso «{$permiso->name}» removido.";
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json([
            'enabled' => $request->boolean('enabled'),
            'message' => $message,
        ]);
    }

    public function destroy(Role $rol): RedirectResponse
    {
        if ($rol->users()->exists()) {
            return back()->with('error', 'No se puede eliminar un rol asignado a usuarios.');
        }

        $rol->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('success', 'Rol eliminado correctamente.');
    }
}
