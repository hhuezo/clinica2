@extends('layouts.menu')

@section('title', 'Clínicas — ' . config('app.name'))

@section('content')
    @include('layouts.partials.datatables-assets')

<div class="row">
<div class="col-xl-12">
<div class="card custom-card">
<div class="card-header justify-content-between">
                    <div class="card-title mb-0">Listado de clínicas</div>
                    @can('clinicas.gestionar')
                        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#drawer-create">Nuevo</button>
                    @endcan
</div>
<div class="card-body">
                    @include('layouts.partials.validation-errors')
<div class="table-responsive">
                        <table id="datatable-basic" class="table table-striped text-nowrap w-100">
                            <thead class="table-dark"><tr>
                                <th>#</th><th>Nombre</th><th>Empresa</th><th>Correo</th><th>Ubicación</th><th>Sucursales</th><th>Activo</th><th>Opciones</th>
                            </tr></thead>
                            <tbody>
                                @foreach ($clinicas as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nombre }}</td>
                                        <td>{{ $item->empresa?->nombre ?? '—' }}</td>
                                        <td>{{ $item->correo ?? '—' }}</td>
                                        <td>{{ $item->distrito?->nombre ?? $item->departamento?->nombre ?? '—' }}</td>
                                        <td>{{ $item->sucursales_count }}</td>
                                        <td>
                                            @if ($item->activo)<span class="badge bg-success-transparent">Sí</span>@else<span class="badge bg-danger-transparent">No</span>@endif
                                        </td>
                                        <td>
                                            @can('clinicas.gestionar')
                                                <button type="button" class="btn btn-sm btn-info btn-wave" data-bs-toggle="offcanvas" data-bs-target="#drawer-edit-{{ $item->id }}"><i class="ri-edit-line"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-wave" data-bs-toggle="offcanvas" data-bs-target="#drawer-delete-{{ $item->id }}"><i class="bi bi-trash-fill"></i></button>
                                            @endcan
                                        </td>
                                    </tr>
                                    @can('clinicas.gestionar')
                                        @include('organizacion.clinica.edit')
                                        @include('organizacion.clinica.delete')
                                    @endcan
                                @endforeach
                            </tbody>
                        </table>
</div>
</div>
</div>
</div>
</div>

    @can('clinicas.gestionar')
<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-create">
<div class="offcanvas-header border-bottom">
                <h6 class="offcanvas-title">Crear clínica</h6>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>
            <form method="POST" action="{{ route('organizacion.clinicas.store') }}">
                @csrf
                <div class="offcanvas-body">
                    <div class="mb-3">
                        <label class="form-label">Empresa <span class="text-danger">*</span></label>
                        <select name="empresa_id" class="form-select" required>
                            <option value="">— Seleccione —</option>
                            @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->id }}" @selected(old('empresa_id') == $empresa->id)>{{ $empresa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Razón social</label>
                        <input type="text" name="razon_social" class="form-control" value="{{ old('razon_social') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIT</label>
                        <input type="text" name="nit" class="form-control" value="{{ old('nit') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo</label>
                        <input type="email" name="correo" class="form-control" value="{{ old('correo') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sitio web</label>
                        <input type="text" name="sitio_web" class="form-control" value="{{ old('sitio_web') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <textarea name="direccion" class="form-control" rows="2">{{ old('direccion') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Departamento</label>
                        <select name="departamento_id" class="form-select js-departamento" data-suffix="create">
                            <option value="">— Seleccione —</option>
                            @foreach ($departamentos as $dept)
                                <option value="{{ $dept->id }}" @selected(old('departamento_id') == $dept->id)>{{ $dept->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Distrito</label>
                        <select name="distrito_id" class="form-select js-distrito" id="distrito-create" data-selected="{{ old('distrito_id', '') }}">
                            <option value="">— Seleccione departamento —</option>
                            @foreach ($departamentos as $dept)
                                @foreach ($dept->distritos as $dist)
                                    <option value="{{ $dist->id }}" data-departamento="{{ $dept->id }}"
                                        @selected(old('distrito_id') == $dist->id)>{{ $dist->nombre }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="activo" value="0">
                        <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo-create" {{ old('activo', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo-create">Activo</label>
                    </div>
                </div>
<div class="border-top p-3 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
</div>
            </form>
</div>
    @endcan

    <script>
    (function () {
        function filtrarDistritos(deptSelect) {
            const suffix = deptSelect.dataset.suffix || 'create';
            const distritoSelect = document.getElementById('distrito-' + suffix);
            if (!distritoSelect) return;
            const deptId = deptSelect.value;
            const selected = distritoSelect.dataset.selected || '';
            let firstVisible = '';
            Array.from(distritoSelect.options).forEach(function (opt, idx) {
                if (idx === 0) {
                    opt.hidden = false;
                    opt.disabled = !deptId;
                    opt.textContent = deptId ? '— Seleccione —' : '— Seleccione departamento —';
                    return;
                }
                const show = !deptId || opt.dataset.departamento === deptId;
                opt.hidden = !show;
                if (show && !firstVisible) firstVisible = opt.value;
            });
            const current = distritoSelect.querySelector('option[value="' + selected + '"]:not([hidden])');
            if (current) {
                distritoSelect.value = selected;
            } else {
                distritoSelect.value = deptId ? firstVisible : '';
                distritoSelect.dataset.selected = distritoSelect.value;
            }
        }
        document.querySelectorAll('.js-departamento').forEach(function (el) {
            filtrarDistritos(el);
            el.addEventListener('change', function () {
                const suffix = el.dataset.suffix || 'create';
                const distritoSelect = document.getElementById('distrito-' + suffix);
                if (distritoSelect) {
                    distritoSelect.dataset.selected = '';
                    distritoSelect.value = '';
                }
                filtrarDistritos(el);
            });
        });
    })();
    </script>
    <script>initDataTable('#datatable-basic', 'organizacionMenu', 'clinicasOption');</script>
@endsection
