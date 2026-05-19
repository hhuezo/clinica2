<x-guest-layout :heading="__('Registro')" :subheading="__('Crea tu cuenta para continuar')">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')"
                :class="'form-control-lg'.($errors->get('name') ? ' is-invalid' : '')" required autofocus
                autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="mb-3">
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')"
                :class="'form-control-lg'.($errors->get('email') ? ' is-invalid' : '')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="mb-3">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" type="password" name="password"
                :class="'form-control-lg'.($errors->get('password') ? ' is-invalid' : '')" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="mb-3">
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                :class="'form-control-lg'.($errors->get('password_confirmation') ? ' is-invalid' : '')" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="d-grid mb-3">
            <x-primary-button class="btn-lg">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>

        <p class="text-center text-muted mb-0 fs-13">
            {{ __('¿Ya tienes cuenta?') }}
            <a href="{{ route('login') }}" class="text-primary fw-semibold">{{ __('Iniciar sesión') }}</a>
        </p>
    </form>
</x-guest-layout>
