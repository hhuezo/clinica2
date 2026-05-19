/**
 * Input uppercase - convierte a mayúsculas el valor de los inputs con clase .input-uppercase
 * Uso: agregar class="input-uppercase" al input o textarea.
 * Incluir este script en el layout para que esté disponible en toda la aplicación.
 */
(function () {
    function applyUppercase(el) {
        if (!el || !el.classList || !el.classList.contains('input-uppercase')) return;
        var s = el.selectionStart;
        var e = el.selectionEnd;
        el.value = el.value.toUpperCase();
        el.setSelectionRange(s, e);
    }

    document.addEventListener('input', function (ev) {
        if (ev.target.matches && ev.target.matches('input.input-uppercase, textarea.input-uppercase')) {
            applyUppercase(ev.target);
        }
    }, true);
})();
