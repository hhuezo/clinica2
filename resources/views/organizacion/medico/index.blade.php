@extends('layouts.menu')
@section('title', 'Médicos — ' . config('app.name'))
@section('content')
    @include('layouts.partials.datatables-assets')
<div class="row">
<div class="col-xl-12">
<div class="card custom-card">
<div class="card-header justify-content-between">
        <div class="card-title mb-0">Listado de médicos</div>
        @can('medicos.gestionar')<button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#drawer-create">Nuevo</button>@endcan
</div>
<div class="card-body">
    @include('layouts.partials.validation-errors')
<div class="table-responsive">
<table id="datatable-basic" class="table table-striped text-nowrap w-100">
<thead class="table-dark"><tr><th>#</th><th>Nombre</th><th>Usuario</th><th>Especialidad</th><th>Sucursales</th><th>Activo</th><th>Opciones</th></tr></thead>
<tbody>
@foreach ($medicos as $item)
<tr>
<td>{{ $item->id }}</td>
<td>{{ $item->nombre_completo }}</td>
<td>{{ $item->usuario?->email ?? '—' }}</td>
<td>{{ $item->especialidad ?? '—' }}</td>
<td>{{ $item->sucursales->count() }}</td>
<td>@if($item->activo)<span class="badge bg-success-transparent">Sí</span>@else<span class="badge bg-danger-transparent">No</span>@endif</td>
<td>
@can('medicos.gestionar')
<button type="button" class="btn btn-sm btn-primary btn-wave" data-bs-toggle="offcanvas" data-bs-target="#drawer-show-{{ $item->id }}"><i class="ri-eye-line"></i></button>
<button type="button" class="btn btn-sm btn-info btn-wave" data-bs-toggle="offcanvas" data-bs-target="#drawer-edit-{{ $item->id }}"><i class="ri-edit-line"></i></button>
<button type="button" class="btn btn-sm btn-danger btn-wave" data-bs-toggle="offcanvas" data-bs-target="#drawer-delete-{{ $item->id }}"><i class="bi bi-trash-fill"></i></button>
@endcan
</td></tr>
@can('medicos.gestionar')
@include('organizacion.medico.show')
@include('organizacion.medico.edit')
@include('organizacion.medico.delete')
@endcan
@endforeach
</tbody></table>
</div>
</div>
</div>
</div>
</div>
@can('medicos.gestionar')
<div class="offcanvas offcanvas-end" id="drawer-create" tabindex="-1">
<div class="offcanvas-header border-bottom">
<h6 class="offcanvas-title">Crear médico</h6><button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>
<form method="POST" action="{{ route('organizacion.medicos.store') }}">@csrf
<div class="offcanvas-body">
                    <div class="mb-3">
                        <label class="form-label">Usuario <span class="text-danger">*</span></label>
                        <select name="usuario_id" class="form-select" required>
                            <option value="">— Seleccione —</option>
                            @foreach ($usuariosDisponibles as $usuario)
                                <option value="{{ $usuario->id }}" @selected(old('usuario_id') == $usuario->id)>{{ $usuario->name }} ({{ $usuario->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombres <span class="text-danger">*</span></label>
                        <input type="text" name="nombres" class="form-control" value="{{ old('nombres') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Apellidos <span class="text-danger">*</span></label>
                        <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Especialidad</label>
                        <input type="text" name="especialidad" class="form-control" value="{{ old('especialidad') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nº colegiado</label>
                        <input type="text" name="numero_colegiado" class="form-control" value="{{ old('numero_colegiado') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biografía</label>
                        <textarea name="biografia" class="form-control" rows="3">{{ old('biografia') }}</textarea>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="activo" value="0">
                        <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo-create" {{ old('activo', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo-create">Activo</label>
                    </div>
    <p class="text-muted small mb-0">Después de crear, asigne sucursales con el icono de detalle.</p>
</div>
<div class="border-top p-3 text-end">
<button type="submit" class="btn btn-primary">Guardar</button>
</div>
</form>
</div>
@endcan
@include('layouts.partials.toggle-sync')
<script>initDataTable('#datatable-basic', 'organizacionMenu', 'medicosOption');</script>
@endsection
