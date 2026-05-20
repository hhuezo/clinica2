<script>
    document.addEventListener('change', function (e) {
        const input = e.target.closest('.js-toggle-sync');
        if (!input || input.disabled) {
            return;
        }

        const url = input.dataset.url;
        if (!url) {
            return;
        }

        const previous = !input.checked;
        input.disabled = true;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ enabled: input.checked }),
        })
            .then(function (response) {
                return response.json().then(function (data) {
                    if (!response.ok) {
                        throw new Error(data.message || 'Error al actualizar.');
                    }
                    return data;
                });
            })
            .then(function (data) {
                if (typeof toastr !== 'undefined') {
                    toastr.success(data.message);
                }
            })
            .catch(function (err) {
                input.checked = previous;
                if (typeof toastr !== 'undefined') {
                    toastr.error(err.message || 'No se pudo actualizar.');
                } else {
                    alert(err.message || 'No se pudo actualizar.');
                }
            })
            .finally(function () {
                input.disabled = false;
            });
    });
</script>
