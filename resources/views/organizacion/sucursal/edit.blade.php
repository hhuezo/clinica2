<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-edit-{{ $item->id }}">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title">Modificar sucursal</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <form method="POST" action="{{ route('organizacion.sucursales.update', $item) }}">
        @csrf
        @method('PUT')
        <div class="offcanvas-body">
            <div class="mb-3">
                <label class="form-label">Clínica <span class="text-danger">*</span></label>
                <select name="clinica_id" class="form-select" required>
                    <option value="">— Seleccione —</option>
                    @foreach ($clinicas as $clinica)
                        <option value="{{ $clinica->id }}" @selected(old('clinica_id', $item->clinica_id) == $clinica->id)>{{ $clinica->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $item->nombre) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Código</label>
                <input type="text" name="codigo" class="form-control" value="{{ old('codigo', $item->codigo) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $item->telefono) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="email" name="correo" class="form-control" value="{{ old('correo', $item->correo) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <textarea name="direccion" class="form-control" rows="2">{{ old('direccion', $item->direccion) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Departamento</label>
                <select name="departamento_id" class="form-select js-departamento" data-suffix="{{ $item->id }}">
                    <option value="">— Seleccione —</option>
                    @foreach ($departamentos as $dept)
                        <option value="{{ $dept->id }}" @selected((string) old('departamento_id', $item->departamento_id ?? '') === (string) $dept->id)>{{ $dept->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Distrito</label>
                <select name="distrito_id" class="form-select js-distrito" id="distrito-{{ $item->id }}" data-selected="{{ old('distrito_id', $item->distrito_id ?? '') }}">
                    <option value="">— Seleccione departamento —</option>
                    @foreach ($departamentos as $dept)
                        @foreach ($dept->distritos as $dist)
                            <option value="{{ $dist->id }}" data-departamento="{{ $dept->id }}"
                                @selected((string) old('distrito_id', $item->distrito_id ?? '') === (string) $dist->id)>{{ $dist->nombre }}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div class="form-check form-switch mb-3">
                <input type="hidden" name="es_principal" value="0">
                <input class="form-check-input" type="checkbox" name="es_principal" value="1" id="es-principal-{{ $item->id }}" {{ old('es_principal', $item->es_principal) ? 'checked' : '' }}>
                <label class="form-check-label" for="es-principal-{{ $item->id }}">Sucursal principal</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input type="hidden" name="activo" value="0">
                <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo-{{ $item->id }}" {{ old('activo', $item->activo) ? 'checked' : '' }}>
                <label class="form-check-label" for="activo-{{ $item->id }}">Activo</label>
            </div>
        </div>
        <div class="border-top p-3 text-end">
            <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
