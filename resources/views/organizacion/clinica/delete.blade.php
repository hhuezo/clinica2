<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-delete-{{ $item->id }}">
<div class="offcanvas-header border-bottom">
    <h6 class="offcanvas-title">Eliminar clínica</h6>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>
<div class="offcanvas-body">
    <p>¿Eliminar la clínica <strong>{{ $item->nombre }}</strong> ({{ $item->empresa?->nombre }})?</p>
    @if ($item->sucursales_count > 0)
        <p class="text-danger small">Tiene {{ $item->sucursales_count }} sucursal(es) asociada(s).</p>
    @endif
</div>
<div class="border-top p-3 d-flex justify-content-end gap-2">
    <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancelar</button>
    <form method="POST" action="{{ route('organizacion.clinicas.destroy', $item) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" @disabled($item->sucursales_count > 0)>Eliminar</button>
    </form>
</div>
</div>
