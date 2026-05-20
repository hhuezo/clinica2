<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-edit-{{ $item->id }}"
    aria-labelledby="drawer-edit-label-{{ $item->id }}">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title" id="drawer-edit-label-{{ $item->id }}">Modificar permiso</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>
    <form method="POST" action="{{ route('seguridad.permisos.update', $item) }}">
        @csrf
        @method('PUT')
        <div class="offcanvas-body">
            <div class="mb-3">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
                <div class="form-text">Ej: pacientes.ver, citas.crear</div>
            </div>
        </div>
        <div class="offcanvas-footer border-top p-3 text-end">
            <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
