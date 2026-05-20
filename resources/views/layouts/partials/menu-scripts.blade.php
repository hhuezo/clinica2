<script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/defaultmenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/js/sticky.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/simplebar.js') }}"></script>

<script>
    function expandMenuAndHighlightOption(menuId, optionId) {
        const menuElement = document.getElementById(menuId);
        const optionElement = document.getElementById(optionId);

        if (menuElement) {
            menuElement.classList.add('is-expanded');
        }

        if (optionElement) {
            optionElement.classList.add('active');
        }
    }
</script>

@stack('scripts')
