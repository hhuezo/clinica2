<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 mb-0">
            {{ __('Panel') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center my-5">
        <div class="col">
            <div class="card custom-card">
                <div class="card-body">
                    {{ __('Has iniciado sesión correctamente.') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
