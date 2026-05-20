
<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-delete-{{ $item->id }}">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title">Eliminar rol</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <p>¿Eliminar el rol <strong>{{ $item->name }}</strong>?</p>
        @if ($item->users_count > 0)
            <p class="text-danger small mb-0">Tiene {{ $item->users_count }} usuario(s) asignado(s).</p>
        @endif
    </div>
    <div class="border-top p-3 d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancelar</button>
        <form method="POST" action="{{ route('seguridad.roles.destroy', $item) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" {{ $item->users_count > 0 ? 'disabled' : '' }}>Eliminar</button>
        </form>
    </div>
</div>
