<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-edit-{{ $item->id }}">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title">Modificar médico</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <form method="POST" action="{{ route('organizacion.medicos.update', $item) }}">
        @csrf
        @method('PUT')
        <div class="offcanvas-body">
            @php
                $usuariosLista = $usuariosDisponibles;
                if (! $usuariosLista->contains('id', $item->usuario_id)) {
                    $usuariosLista = $usuariosDisponibles->concat([$item->usuario]);
                }
            @endphp
            <div class="mb-3">
                <label class="form-label">Usuario <span class="text-danger">*</span></label>
                <select name="usuario_id" class="form-select" required>
                    <option value="">— Seleccione —</option>
                    @foreach ($usuariosLista as $usuario)
                        <option value="{{ $usuario->id }}" @selected(old('usuario_id', $item->usuario_id) == $usuario->id)>{{ $usuario->name }} ({{ $usuario->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombres <span class="text-danger">*</span></label>
                <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $item->nombres) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Apellidos <span class="text-danger">*</span></label>
                <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $item->apellidos) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Especialidad</label>
                <input type="text" name="especialidad" class="form-control" value="{{ old('especialidad', $item->especialidad) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Nº colegiado</label>
                <input type="text" name="numero_colegiado" class="form-control" value="{{ old('numero_colegiado', $item->numero_colegiado) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $item->telefono) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Biografía</label>
                <textarea name="biografia" class="form-control" rows="3">{{ old('biografia', $item->biografia) }}</textarea>
            </div>
            <div class="form-check form-switch mb-3">
                <input type="hidden" name="activo" value="0">
                <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo-{{ $item->id }}" {{ old('activo', $item->activo) ? 'checked' : '' }}>
                <label class="form-check-label" for="activo-{{ $item->id }}">Activo</label>
            </div>
            <p class="text-muted small mb-0">Las sucursales se gestionan en el drawer de detalle.</p>
        </div>
        <div class="border-top p-3 text-end">
            <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
