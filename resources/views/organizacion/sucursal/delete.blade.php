<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-delete-{{ $item->id }}">
<div class="offcanvas-header border-bottom">
    <h6 class="offcanvas-title">Eliminar sucursal</h6>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>
<div class="offcanvas-body">
    <p>¿Eliminar la sucursal <strong>{{ $item->nombre }}</strong>?</p>
</div>
<div class="border-top p-3 d-flex justify-content-end gap-2">
    <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancelar</button>
    <form method="POST" action="{{ route('organizacion.sucursales.destroy', $item) }}">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">Eliminar</button>
    </form>
</div>
</div>
