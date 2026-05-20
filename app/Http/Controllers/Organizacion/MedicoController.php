<?php

namespace App\Http\Controllers\Organizacion;

use App\Http\Controllers\Controller;
use App\Models\Medico;
use App\Models\Seguridad\User;
use App\Models\Sucursal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MedicoController extends Controller
{
    public function index(): View
    {
        $medicos = Medico::query()
            ->with(['usuario', 'sucursales.clinica'])
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        $sucursales = Sucursal::query()
            ->with('clinica')
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        $usuariosDisponibles = User::query()
            ->where('activo', true)
            ->whereDoesntHave('medico')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('organizacion.medico.index', compact('medicos', 'sucursales', 'usuariosDisponibles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateMedico($request);

        Medico::create($validated);

        return back()->with('success', 'Médico creado correctamente. Asigne sucursales desde el detalle.');
    }

    public function update(Request $request, Medico $medico): RedirectResponse
    {
        $validated = $this->validateMedico($request, $medico);

        $medico->update($validated);

        return back()->with('success', 'Médico actualizado correctamente.');
    }

    public function toggleSucursal(Request $request, Medico $medico, Sucursal $sucursal): JsonResponse
    {
        $request->validate(['enabled' => ['required', 'boolean']]);

        if ($request->boolean('enabled')) {
            $medico->sucursales()->syncWithoutDetaching([$sucursal->id]);
            $message = "Sucursal «{$sucursal->nombre}» asignada.";
        } else {
            $medico->sucursales()->detach($sucursal->id);
            $message = "Sucursal «{$sucursal->nombre}» removida.";
        }

        return response()->json([
            'enabled' => $request->boolean('enabled'),
            'message' => $message,
        ]);
    }

    public function destroy(Medico $medico): RedirectResponse
    {
        if ($medico->citas()->exists()) {
            return back()->with('error', 'No se puede eliminar un médico con citas registradas.');
        }

        $medico->delete();

        return back()->with('success', 'Médico eliminado correctamente.');
    }

    private function validateMedico(Request $request, ?Medico $medico = null): array
    {
        $validated = $request->validate([
            'usuario_id' => [
                'required',
                'exists:users,id',
                Rule::unique('medicos', 'usuario_id')->ignore($medico?->id),
            ],
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'especialidad' => ['nullable', 'string', 'max:255'],
            'numero_colegiado' => ['nullable', 'string', 'max:50'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'biografia' => ['nullable', 'string'],
            'activo' => ['nullable', 'boolean'],
        ], [
            'usuario_id.required' => 'Debe seleccionar un usuario.',
            'usuario_id.unique' => 'Este usuario ya está vinculado a otro médico.',
            'nombres.required' => 'Los nombres son obligatorios.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
        ]);

        $validated['activo'] = $request->boolean('activo');

        return $validated;
    }
}
