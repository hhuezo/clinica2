
<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-show-{{ $item->id }}">
    <div class="offcanvas-header border-bottom">
        <div>
            <h6 class="offcanvas-title mb-0">Permisos del rol</h6>
            <p class="text-muted small mb-0">{{ $item->name }}</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <p class="text-muted small px-3 pt-3">Active o desactive cada permiso.</p>
        <div class="list-group list-group-flush px-0" style="max-height: calc(100vh - 180px); overflow-y: auto;">
            @foreach ($permisos as $permiso)
                <label class="list-group-item d-flex align-items-center justify-content-between py-2 px-3">
                    <span class="small">{{ $permiso->name }}</span>
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" class="form-check-input js-toggle-sync" role="switch"
                            data-url="{{ route('seguridad.roles.permisos.toggle', [$item, $permiso]) }}"
                            @checked($item->hasPermissionTo($permiso->name))>
                    </div>
                </label>
            @endforeach
        </div>
    </div>
</div>
