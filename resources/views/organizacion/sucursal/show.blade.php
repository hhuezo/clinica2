<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-show-{{ $item->id }}">
<div class="offcanvas-header border-bottom">
    <div>
        <h6 class="offcanvas-title mb-0">Médicos de la sucursal</h6>
        <p class="text-muted small mb-0">{{ $item->nombre }} — {{ $item->clinica?->nombre }}</p>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>
<div class="offcanvas-body">
    <p class="text-muted small">Active o desactive cada médico. Los cambios se guardan al instante.</p>
<div class="list-group list-group-flush">
        @foreach ($medicos as $medico)
<div class="list-group-item d-flex align-items-center justify-content-between py-3">
            <span>{{ $medico->nombre_completo }}@if($medico->especialidad)<span class="text-muted small d-block">{{ $medico->especialidad }}</span>@endif</span>
<div class="form-check form-switch mb-0">
                <input type="checkbox" class="form-check-input js-toggle-sync" role="switch"
                    data-url="{{ route('organizacion.sucursales.medicos.toggle', [$item, $medico]) }}"
                    @checked($item->medicos->contains($medico->id))>
</div>
</div>
        @endforeach
</div>
</div>
</div>
