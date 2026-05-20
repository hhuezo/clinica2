<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-show-{{ $item->id }}">
<div class="offcanvas-header border-bottom">
<div>
        <h6 class="offcanvas-title mb-0">Sucursales del médico</h6>
        <p class="text-muted small mb-0">{{ $item->nombre_completo }}</p>
</div>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>
<div class="offcanvas-body">
    <p class="text-muted small">Active o desactive cada sucursal.</p>
<div class="list-group list-group-flush">
    @foreach ($sucursales as $sucursal)
<div class="list-group-item d-flex align-items-center justify-content-between py-3">
        <span>{{ $sucursal->nombre }}<span class="text-muted small d-block">{{ $sucursal->clinica?->nombre }}</span></span>
<div class="form-check form-switch mb-0">
            <input type="checkbox" class="form-check-input js-toggle-sync" role="switch"
                data-url="{{ route('organizacion.medicos.sucursales.toggle', [$item, $sucursal]) }}"
                @checked($item->sucursales->contains($sucursal->id))>
</div>
</div>
    @endforeach
</div>
</div>
</div>
