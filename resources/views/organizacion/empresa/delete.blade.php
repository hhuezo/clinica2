<div class="offcanvas offcanvas-end" tabindex="-1" id="drawer-delete-{{ $item->id }}">
<div class="offcanvas-header border-bottom">
    <h6 class="offcanvas-title">Eliminar empresa</h6>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>
<div class="offcanvas-body">
    <p>¿Eliminar la empresa <strong>{{ $item->nombre }}</strong>?</p>
    @if ($item->clinicas_count > 0)
        <p class="text-danger small">Tiene {{ $item->clinicas_count }} clínica(s) asociada(s).</p>
    @endif
</div>
<div class="border-top p-3 d-flex justify-content-end gap-2">
    <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancelar</button>
    <form method="POST" action="{{ route('organizacion.empresas.destroy', $item) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" @disabled($item->clinicas_count > 0)>Eliminar</button>
    </form>
</div>
</div>
