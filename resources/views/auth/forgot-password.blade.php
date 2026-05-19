<x-guest-layout :heading="__('Recuperar contraseña')"
    :subheading="__('Indica tu correo y te enviaremos un enlace para restablecer la contraseña.')">
    <x-auth-session-status class="alert alert-success" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')"
                :class="'form-control-lg'.($errors->get('email') ? ' is-invalid' : '')" required autofocus />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="d-grid">
            <x-primary-button class="btn-lg">
                {{ __('Enviar enlace') }}
            </x-primary-button>
        </div>

        <p class="text-center text-muted mt-4 mb-0 fs-13">
            <a href="{{ route('login') }}" class="text-primary fw-semibold">{{ __('Volver al inicio de sesión') }}</a>
        </p>
    </form>
</x-guest-layout>
