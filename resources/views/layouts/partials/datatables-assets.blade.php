<link href="{{ asset('assets/libs/dataTables/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<script src="{{ asset('assets/libs/dataTables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/dataTables/dataTables.bootstrap5.min.js') }}"></script>
<script>
    window.initDataTable = function (selector, menuId, menuOptionId) {
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof expandMenuAndHighlightOption === 'function' && menuId && menuOptionId) {
                expandMenuAndHighlightOption(menuId, menuOptionId);
            }

            $(selector).DataTable({
                language: {
                    processing: 'Procesando...',
                    search: 'Buscar:',
                    lengthMenu: 'Mostrar _MENU_ registros',
                    info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                    infoEmpty: 'Sin registros',
                    infoFiltered: '(filtrado de _MAX_ registros)',
                    loadingRecords: 'Cargando...',
                    zeroRecords: 'No se encontraron resultados',
                    emptyTable: 'Sin datos disponibles',
                    paginate: { first: '<<', previous: '<', next: '>', last: '>>' }
                }
            });
        });
    };
</script>
