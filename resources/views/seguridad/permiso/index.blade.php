@extends('layouts.menu')
@section('title', 'Permisos — ' . config('app.name'))
@section('content')
@include('layouts.partials.datatables-assets')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title mb-0">Listado de permisos</div>
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
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permisos as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info btn-wave" title="Editar"
                                            data-bs-toggle="offcanvas" data-bs-target="#drawer-edit-{{ $item->id }}">
                                            <i class="ri-edit-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger btn-wave" title="Eliminar"
                                            data-bs-toggle="offcanvas" data-bs-target="#drawer-delete-{{ $item->id }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                                @include('seguridad.permiso.edit')
                                @include('seguridad.permiso.delete')
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
        <h6 class="offcanvas-title">Crear permiso</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <form method="POST" action="{{ route('seguridad.permisos.store') }}">
        @csrf
        <div class="offcanvas-body">
            <div class="mb-3">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
        </div>
        <div class="border-top p-3 text-end">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>

<script>initDataTable('#datatable-basic', 'seguridadMenu', 'permisosOption');</script>
@endsection
