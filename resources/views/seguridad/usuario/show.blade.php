
<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-show-{{ $item->id }}">
    <div class="offcanvas-header border-bottom">
        <div>
            <h6 class="offcanvas-title mb-0">Roles del usuario</h6>
            <p class="text-muted small mb-0">{{ $item->name }}</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <p class="text-muted small">Active o desactive cada rol. Los cambios se guardan al instante.</p>
        <div class="list-group list-group-flush">
            @foreach ($roles as $rol)
                <label class="list-group-item d-flex align-items-center justify-content-between py-3">
                    <span>{{ $rol->name }}</span>
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" class="form-check-input js-toggle-sync" role="switch"
                            data-url="{{ route('seguridad.usuarios.roles.toggle', [$item, $rol]) }}"
                            @checked($item->hasRole($rol->name))>
                    </div>
                </label>
            @endforeach
        </div>
    </div>
</div>
