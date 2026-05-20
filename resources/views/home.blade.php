@extends('layouts.menu')

@section('title', 'Inicio — ' . config('app.name'))

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById('homeOption');
        if (el) el.classList.add('active');
    });
</script>
@endpush

@section('content')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Inicio</h1>
            <p class="text-muted mb-0">Bienvenido al sistema de gestión clínica</p>
        </div>
    </div>

    @php
        $usuario = auth()->user();
        $usuario->loadMissing(['empresa', 'clinica', 'sucursal']);
    @endphp

    <div class="row">
        <div class="col-xl-4 col-lg-6 col-md-6 mb-3">
            <div class="card custom-card">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Usuario</h6>
                    <p class="fw-semibold mb-1">{{ $usuario->name }}</p>
                    <p class="mb-0 small text-muted">{{ $usuario->email }}</p>
                    <p class="mb-0 small"><span class="badge bg-primary-transparent">{{ $usuario->getRoleNames()->first() }}</span></p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 mb-3">
            <div class="card custom-card">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Ámbito de trabajo</h6>
                    @if ($usuario->empresa)
                        <p class="mb-1"><strong>Empresa:</strong> {{ $usuario->empresa->nombre }}</p>
                    @endif
                    @if ($usuario->clinica)
                        <p class="mb-1"><strong>Clínica:</strong> {{ $usuario->clinica->nombre }}</p>
                    @endif
                    @if ($usuario->sucursal)
                        <p class="mb-0"><strong>Sucursal:</strong> {{ $usuario->sucursal->nombre }}</p>
                    @endif
                    @if (! $usuario->empresa_id && ! $usuario->clinica_id && ! $usuario->sucursal_id)
                        <p class="mb-0 text-muted">Acceso global (administrador)</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 mb-3">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title mb-0">Accesos rápidos</div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @can('pacientes.ver')
                            <span class="badge bg-light text-dark">Pacientes</span>
                        @endcan
                        @can('citas.ver')
                            <span class="badge bg-light text-dark">Citas</span>
                        @endcan
                        @can('historiales.ver')
                            <span class="badge bg-light text-dark">Historiales</span>
                        @endcan
                    </div>
                    <p class="text-muted small mb-0 mt-3">Los módulos del menú lateral estarán disponibles conforme se implementen las pantallas.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
