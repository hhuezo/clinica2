<?php

namespace App\Http\Controllers\Organizacion;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Organizacion\Concerns\CargaCatalogoUbicacion;
use App\Models\Clinica;
use App\Models\Empresa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClinicaController extends Controller
{
    use CargaCatalogoUbicacion;

    public function index(): View
    {
        $clinicas = Clinica::query()
            ->with(['empresa', 'departamento', 'distrito'])
            ->withCount('sucursales')
            ->orderBy('nombre')
            ->get();

        $empresas = Empresa::query()->where('activo', true)->orderBy('nombre')->get(['id', 'nombre']);

        return view('organizacion.clinica.index', array_merge(
            compact('clinicas', 'empresas'),
            $this->catalogoUbicacion()
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateClinica($request);

        Clinica::create($validated);

        return back()->with('success', 'Clínica creada correctamente.');
    }

    public function update(Request $request, Clinica $clinica): RedirectResponse
    {
        $validated = $this->validateClinica($request, $clinica);

        $clinica->update($validated);

        return back()->with('success', 'Clínica actualizada correctamente.');
    }

    public function destroy(Clinica $clinica): RedirectResponse
    {
        if ($clinica->sucursales()->exists()) {
            return back()->with('error', 'No se puede eliminar una clínica con sucursales asociadas.');
        }

        $clinica->delete();

        return back()->with('success', 'Clínica eliminada correctamente.');
    }

    private function validateClinica(Request $request, ?Clinica $clinica = null): array
    {
        $validated = $request->validate([
            'empresa_id' => ['required', 'exists:empresas,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'razon_social' => ['nullable', 'string', 'max:255'],
            'nit' => ['nullable', 'string', 'max:20'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'correo' => ['nullable', 'email', 'max:255'],
            'sitio_web' => ['nullable', 'string', 'max:255'],
            'direccion' => ['nullable', 'string'],
            'departamento_id' => ['nullable', 'exists:departamentos,id'],
            'distrito_id' => ['nullable', 'exists:distritos,id'],
            'activo' => ['nullable', 'boolean'],
        ], [
            'empresa_id.required' => 'Debe seleccionar una empresa.',
            'nombre.required' => 'El nombre es obligatorio.',
            'correo.email' => 'El correo no es válido.',
        ]);

        $validated['activo'] = $request->boolean('activo');

        return $validated;
    }
}
