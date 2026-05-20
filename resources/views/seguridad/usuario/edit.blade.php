<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-edit-{{ $item->id }}">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title">Modificar usuario</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <form method="POST" action="{{ route('seguridad.usuarios.update', $item) }}">
        @csrf
        @method('PUT')
        <div class="offcanvas-body">
            <div class="mb-3">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Correo <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $item->email) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $item->telefono) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control">
                <div class="form-text">Dejar en blanco para no cambiar.</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div class="form-check form-switch mb-3">
                <input type="hidden" name="activo" value="0">
                <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo-edit-{{ $item->id }}"
                    {{ old('activo', $item->activo) ? 'checked' : '' }}>
                <label class="form-check-label" for="activo-edit-{{ $item->id }}">Activo</label>
            </div>
            <div class="mb-3">
                <label class="form-label">Empresa</label>
                <select name="empresa_id" class="form-select">
                    <option value="">— Sin asignar —</option>
                    @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->id }}" @selected(old('empresa_id', $item->empresa_id) == $empresa->id)>{{ $empresa->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Clínica</label>
                <select name="clinica_id" class="form-select">
                    <option value="">— Sin asignar —</option>
                    @foreach ($clinicas as $clinica)
                        <option value="{{ $clinica->id }}" @selected(old('clinica_id', $item->clinica_id) == $clinica->id)>{{ $clinica->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Sucursal</label>
                <select name="sucursal_id" class="form-select">
                    <option value="">— Sin asignar —</option>
                    @foreach ($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}" @selected(old('sucursal_id', $item->sucursal_id) == $sucursal->id)>{{ $sucursal->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <p class="text-muted small mb-0">Los roles se gestionan en el drawer de detalle (icono ojo).</p>
        </div>
        <div class="border-top p-3 text-end">
            <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
