@extends('layouts.menu')

@section('title', 'Usuarios — ' . config('app.name'))

@section('content')
    @include('layouts.partials.datatables-assets')

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title mb-0">Listado de usuarios</div>
                    <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#drawer-create">Nuevo</button>
                </div>
                <div class="card-body">
                    @include('layouts.partials.validation-errors')
                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-striped text-nowrap w-100">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Empresa</th>
                                    <th>Roles</th>
                                    <th>Activo</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->empresa?->nombre ?? '—' }}</td>
                                        <td>
                                            @forelse ($item->roles as $rol)
                                                <span class="badge bg-primary-transparent me-1">{{ $rol->name }}</span>
                                            @empty
                                                <span class="text-muted">—</span>
                                            @endforelse
                                        </td>
                                        <td>
                                            @if ($item->activo)
                                                <span class="badge bg-success-transparent">Sí</span>
                                            @else
                                                <span class="badge bg-danger-transparent">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary btn-wave" title="Roles"
                                                data-bs-toggle="offcanvas" data-bs-target="#drawer-show-{{ $item->id }}">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-info btn-wave" title="Editar"
                                                data-bs-toggle="offcanvas" data-bs-target="#drawer-edit-{{ $item->id }}">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger btn-wave" title="Eliminar"
                                                data-bs-toggle="offcanvas" data-bs-target="#drawer-delete-{{ $item->id }}"
                                                @disabled($item->id === auth()->id())>
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @include('seguridad.usuario.show')
                                    @include('seguridad.usuario.edit')
                                    @include('seguridad.usuario.delete')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-create">
        <div class="offcanvas-header border-bottom">
            <h6 class="offcanvas-title">Crear usuario</h6>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <form method="POST" action="{{ route('seguridad.usuarios.store') }}">
            @csrf
            <div class="offcanvas-body">
                <div class="mb-3">
                    <label class="form-label">Nombre <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Correo <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirmar contraseña <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="form-check form-switch mb-3">
                    <input type="hidden" name="activo" value="0">
                    <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo-create" {{ old('activo', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="activo-create">Activo</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Empresa</label>
                    <select name="empresa_id" class="form-select"><option value="">— Sin asignar —</option>
                    @foreach ($empresas as $empresa)<option value="{{ $empresa->id }}" @selected(old('empresa_id') == $empresa->id)>{{ $empresa->nombre }}</option>@endforeach</select>
                </div>
                <div class="mb-3"><label class="form-label">Clínica</label><select name="clinica_id" class="form-select"><option value="">— Sin asignar —</option>@foreach ($clinicas as $clinica)<option value="{{ $clinica->id }}" @selected(old('clinica_id') == $clinica->id)>{{ $clinica->nombre }}</option>@endforeach</select></div>
                <div class="mb-3"><label class="form-label">Sucursal</label><select name="sucursal_id" class="form-select"><option value="">— Sin asignar —</option>@foreach ($sucursales as $sucursal)<option value="{{ $sucursal->id }}" @selected(old('sucursal_id') == $sucursal->id)>{{ $sucursal->nombre }}</option>@endforeach</select></div>
                <p class="text-muted small mb-0">Después de crear, asigne roles con el icono de detalle.</p>
            </div>
            <div class="border-top p-3 text-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>

    @include('layouts.partials.toggle-sync')
    <script>initDataTable('#datatable-basic', 'seguridadMenu', 'usuariosOption');</script>
@endsection
