<?php

namespace App\Http\Controllers\Organizacion;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Organizacion\Concerns\CargaCatalogoUbicacion;
use App\Models\Empresa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EmpresaController extends Controller
{
    use CargaCatalogoUbicacion;

    public function index(): View
    {
        $empresas = Empresa::query()
            ->with(['departamento', 'distrito'])
            ->withCount('clinicas')
            ->orderBy('nombre')
            ->get();

        return view('organizacion.empresa.index', array_merge(
            compact('empresas'),
            $this->catalogoUbicacion()
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateEmpresa($request);

        Empresa::create($validated);

        return back()->with('success', 'Empresa creada correctamente.');
    }

    public function update(Request $request, Empresa $empresa): RedirectResponse
    {
        $validated = $this->validateEmpresa($request, $empresa);

        $empresa->update($validated);

        return back()->with('success', 'Empresa actualizada correctamente.');
    }

    public function destroy(Empresa $empresa): RedirectResponse
    {
        if ($empresa->clinicas()->exists()) {
            return back()->with('error', 'No se puede eliminar una empresa con clínicas asociadas.');
        }

        $empresa->delete();

        return back()->with('success', 'Empresa eliminada correctamente.');
    }

    private function validateEmpresa(Request $request, ?Empresa $empresa = null): array
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'razon_social' => ['nullable', 'string', 'max:255'],
            'nit' => ['nullable', 'string', 'max:20', Rule::unique('empresas', 'nit')->ignore($empresa?->id)],
            'telefono' => ['nullable', 'string', 'max:30'],
            'correo' => ['nullable', 'email', 'max:255'],
            'sitio_web' => ['nullable', 'string', 'max:255'],
            'direccion' => ['nullable', 'string'],
            'departamento_id' => ['nullable', 'exists:departamentos,id'],
            'distrito_id' => ['nullable', 'exists:distritos,id'],
            'activo' => ['nullable', 'boolean'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nit.unique' => 'Ya existe una empresa con este NIT.',
            'correo.email' => 'El correo no es válido.',
        ]);

        $validated['activo'] = $request->boolean('activo');

        return $validated;
    }
}
