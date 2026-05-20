<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Models\Clinica;
use App\Models\Empresa;
use App\Models\Seguridad\Role;
use App\Models\Seguridad\User;
use App\Models\Sucursal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\PermissionRegistrar;

class UsuarioController extends Controller
{
    public function index(): View
    {
        $usuarios = User::query()
            ->with(['roles', 'empresa', 'clinica', 'sucursal'])
            ->orderBy('name')
            ->get();

        $roles = Role::query()->where('guard_name', 'web')->orderBy('name')->get();
        $empresas = Empresa::query()->orderBy('nombre')->get(['id', 'nombre']);
        $clinicas = Clinica::query()->orderBy('nombre')->get(['id', 'nombre', 'empresa_id']);
        $sucursales = Sucursal::query()->orderBy('nombre')->get(['id', 'nombre', 'clinica_id']);

        return view('seguridad.usuario.index', compact('usuarios', 'roles', 'empresas', 'clinicas', 'sucursales'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'activo' => ['nullable', 'boolean'],
            'empresa_id' => ['nullable', 'exists:empresas,id'],
            'clinica_id' => ['nullable', 'exists:clinicas,id'],
            'sucursal_id' => ['nullable', 'exists:sucursales,id'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.unique' => 'Ya existe un usuario con este correo.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        $usuario = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'telefono' => $validated['telefono'] ?? null,
            'activo' => $request->boolean('activo'),
            'empresa_id' => $validated['empresa_id'] ?? null,
            'clinica_id' => $validated['clinica_id'] ?? null,
            'sucursal_id' => $validated['sucursal_id'] ?? null,
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('success', 'Usuario creado correctamente. Asigne roles desde el detalle.');
    }

    public function update(Request $request, User $usuario): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($usuario->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'activo' => ['nullable', 'boolean'],
            'empresa_id' => ['nullable', 'exists:empresas,id'],
            'clinica_id' => ['nullable', 'exists:clinicas,id'],
            'sucursal_id' => ['nullable', 'exists:sucursales,id'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.unique' => 'Ya existe un usuario con este correo.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        $usuario->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'] ?? null,
            'activo' => $request->boolean('activo'),
            'empresa_id' => $validated['empresa_id'] ?? null,
            'clinica_id' => $validated['clinica_id'] ?? null,
            'sucursal_id' => $validated['sucursal_id'] ?? null,
        ]);

        if (! empty($validated['password'])) {
            $usuario->password = Hash::make($validated['password']);
        }

        $usuario->save();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('success', 'Usuario actualizado correctamente.');
    }

    public function toggleRol(Request $request, User $usuario, Role $rol): JsonResponse
    {
        $request->validate(['enabled' => ['required', 'boolean']]);

        if ($request->boolean('enabled')) {
            $usuario->assignRole($rol);
            $message = "Rol «{$rol->name}» asignado.";
        } else {
            if ($usuario->id === Auth::id() && $usuario->roles()->count() <= 1 && $usuario->hasRole($rol)) {
                return response()->json(['message' => 'No puede quitarse su único rol.'], 422);
            }
            $usuario->removeRole($rol);
            $message = "Rol «{$rol->name}» removido.";
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json([
            'enabled' => $request->boolean('enabled'),
            'message' => $message,
        ]);
    }

    public function destroy(User $usuario): RedirectResponse
    {
        if ($usuario->id === Auth::id()) {
            return back()->with('error', 'No puede eliminar su propio usuario.');
        }

        $usuario->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('success', 'Usuario eliminado correctamente.');
    }
}
