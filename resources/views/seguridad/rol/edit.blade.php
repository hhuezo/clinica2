
<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-edit-{{ $item->id }}">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title">Modificar rol</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <form method="POST" action="{{ route('seguridad.roles.update', $item) }}">
        @csrf
        @method('PUT')
        <div class="offcanvas-body">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
            </div>
            <p class="text-muted small mb-0">Los permisos se gestionan en el drawer de detalle (icono ojo).</p>
        </div>
        <div class="border-top p-3 text-end">
            <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
