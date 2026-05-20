<?php

namespace App\Http\Controllers\Organizacion;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Organizacion\Concerns\CargaCatalogoUbicacion;
use App\Models\Clinica;
use App\Models\Medico;
use App\Models\Sucursal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SucursalController extends Controller
{
    use CargaCatalogoUbicacion;

    public function index(): View
    {
        $sucursales = Sucursal::query()
            ->with(['clinica.empresa', 'departamento', 'distrito', 'medicos'])
            ->withCount('medicos')
            ->orderBy('nombre')
            ->get();

        $clinicas = Clinica::query()->where('activo', true)->orderBy('nombre')->get(['id', 'nombre', 'empresa_id']);
        $medicos = Medico::query()->where('activo', true)->orderBy('apellidos')->orderBy('nombres')->get();

        return view('organizacion.sucursal.index', array_merge(
            compact('sucursales', 'clinicas', 'medicos'),
            $this->catalogoUbicacion()
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateSucursal($request);

        Sucursal::create($validated);

        return back()->with('success', 'Sucursal creada correctamente. Asigne médicos desde el detalle.');
    }

    public function update(Request $request, Sucursal $sucursal): RedirectResponse
    {
        $validated = $this->validateSucursal($request, $sucursal);

        $sucursal->update($validated);

        return back()->with('success', 'Sucursal actualizada correctamente.');
    }

    public function toggleMedico(Request $request, Sucursal $sucursal, Medico $medico): JsonResponse
    {
        $request->validate(['enabled' => ['required', 'boolean']]);

        if ($request->boolean('enabled')) {
            $sucursal->medicos()->syncWithoutDetaching([$medico->id]);
            $message = "Médico «{$medico->nombre_completo}» asignado.";
        } else {
            $sucursal->medicos()->detach($medico->id);
            $message = "Médico «{$medico->nombre_completo}» removido.";
        }

        return response()->json([
            'enabled' => $request->boolean('enabled'),
            'message' => $message,
        ]);
    }

    public function destroy(Sucursal $sucursal): RedirectResponse
    {
        if ($sucursal->citas()->exists() || $sucursal->usuarios()->exists()) {
            return back()->with('error', 'No se puede eliminar una sucursal con citas o usuarios asociados.');
        }

        $sucursal->delete();

        return back()->with('success', 'Sucursal eliminada correctamente.');
    }

    private function validateSucursal(Request $request, ?Sucursal $sucursal = null): array
    {
        $validated = $request->validate([
            'clinica_id' => ['required', 'exists:clinicas,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'codigo' => ['nullable', 'string', 'max:20'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'correo' => ['nullable', 'email', 'max:255'],
            'direccion' => ['nullable', 'string'],
            'departamento_id' => ['nullable', 'exists:departamentos,id'],
            'distrito_id' => ['nullable', 'exists:distritos,id'],
            'es_principal' => ['nullable', 'boolean'],
            'activo' => ['nullable', 'boolean'],
        ], [
            'clinica_id.required' => 'Debe seleccionar una clínica.',
            'nombre.required' => 'El nombre es obligatorio.',
            'correo.email' => 'El correo no es válido.',
        ]);

        $validated['es_principal'] = $request->boolean('es_principal');
        $validated['activo'] = $request->boolean('activo');

        return $validated;
    }
}
