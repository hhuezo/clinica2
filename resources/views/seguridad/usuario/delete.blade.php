
<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-delete-{{ $item->id }}">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title">Eliminar usuario</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <p>¿Eliminar al usuario <strong>{{ $item->name }}</strong> ({{ $item->email }})?</p>
    </div>
    <div class="border-top p-3 d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancelar</button>
        <form method="POST" action="{{ route('seguridad.usuarios.destroy', $item) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </div>
</div>
