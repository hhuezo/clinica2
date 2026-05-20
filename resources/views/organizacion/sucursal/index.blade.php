@extends('layouts.menu')
@section('title', 'Sucursales — ' . config('app.name'))
@section('content')
    @include('layouts.partials.datatables-assets')
<div class="row">
<div class="col-xl-12">
<div class="card custom-card">
<div class="card-header justify-content-between">
        <div class="card-title mb-0">Listado de sucursales</div>
        @can('sucursales.gestionar')<button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#drawer-create">Nuevo</button>@endcan
</div>
<div class="card-body">
    @include('layouts.partials.validation-errors')
<div class="table-responsive">
<table id="datatable-basic" class="table table-striped text-nowrap w-100">
<thead class="table-dark"><tr><th>#</th><th>Nombre</th><th>Clínica</th><th>Empresa</th><th>Principal</th><th>Médicos</th><th>Activo</th><th>Opciones</th></tr></thead>
<tbody>
@foreach ($sucursales as $item)
<tr>
<td>{{ $item->id }}</td>
<td>{{ $item->nombre }}</td>
<td>{{ $item->clinica?->nombre ?? '—' }}</td>
<td>{{ $item->clinica?->empresa?->nombre ?? '—' }}</td>
<td>@if($item->es_principal)<span class="badge bg-info-transparent">Sí</span>@else<span class="text-muted">No</span>@endif</td>
<td>{{ $item->medicos_count }}</td>
<td>@if($item->activo)<span class="badge bg-success-transparent">Sí</span>@else<span class="badge bg-danger-transparent">No</span>@endif</td>
<td>
@can('sucursales.gestionar')
<button type="button" class="btn btn-sm btn-primary btn-wave" data-bs-toggle="offcanvas" data-bs-target="#drawer-show-{{ $item->id }}"><i class="ri-eye-line"></i></button>
<button type="button" class="btn btn-sm btn-info btn-wave" data-bs-toggle="offcanvas" data-bs-target="#drawer-edit-{{ $item->id }}"><i class="ri-edit-line"></i></button>
<button type="button" class="btn btn-sm btn-danger btn-wave" data-bs-toggle="offcanvas" data-bs-target="#drawer-delete-{{ $item->id }}"><i class="bi bi-trash-fill"></i></button>
@endcan
</td></tr>
@can('sucursales.gestionar')
@include('organizacion.sucursal.show')
@include('organizacion.sucursal.edit')
@include('organizacion.sucursal.delete')
@endcan
@endforeach
</tbody></table>
</div>
</div>
</div>
</div>
</div>
@can('sucursales.gestionar')
<div class="offcanvas offcanvas-end" id="drawer-create" tabindex="-1">
<div class="offcanvas-header border-bottom">
<h6 class="offcanvas-title">Crear sucursal</h6><button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>
<form method="POST" action="{{ route('organizacion.sucursales.store') }}">@csrf
<div class="offcanvas-body">
                    <div class="mb-3">
                        <label class="form-label">Clínica <span class="text-danger">*</span></label>
                        <select name="clinica_id" class="form-select" required>
                            <option value="">— Seleccione —</option>
                            @foreach ($clinicas as $clinica)
                                <option value="{{ $clinica->id }}" @selected(old('clinica_id') == $clinica->id)>{{ $clinica->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código</label>
                        <input type="text" name="codigo" class="form-control" value="{{ old('codigo') }}">
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
                        <input type="hidden" name="es_principal" value="0">
                        <input class="form-check-input" type="checkbox" name="es_principal" value="1" id="es-principal-create" {{ old('es_principal') ? 'checked' : '' }}>
                        <label class="form-check-label" for="es-principal-create">Sucursal principal</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="activo" value="0">
                        <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo-create" {{ old('activo', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo-create">Activo</label>
                    </div>
    <p class="text-muted small mb-0">Después de crear, asigne médicos con el icono de detalle.</p>
</div>
<div class="border-top p-3 text-end">
<button type="submit" class="btn btn-primary">Guardar</button>
</div>
</form>
</div>
@endcan
@include('layouts.partials.toggle-sync')
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
<script>initDataTable('#datatable-basic', 'organizacionMenu', 'sucursalesOption');</script>
@endsection
