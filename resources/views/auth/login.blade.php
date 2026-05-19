<x-guest-layout :heading="__('Iniciar sesión')" :subheading="__('Bienvenido de nuevo')">
    <x-auth-session-status class="alert alert-success" :status="session('status')" />

    @include('layouts.partials.auth-social')

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')"
                :class="'form-control-lg'.($errors->get('email') ? ' is-invalid' : '')" required autofocus
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <x-input-label for="password" :value="__('Contraseña')" />
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="fs-12 text-primary">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif
            </div>
            <x-text-input id="password" type="password" name="password"
                :class="'form-control-lg'.($errors->get('password') ? ' is-invalid' : '')" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="form-check mb-3">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label">
                {{ __('Recordarme') }}
            </label>
        </div>

        <div class="d-grid">
            <x-primary-button class="btn-lg">
                {{ __('Iniciar sesión') }}
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <p class="text-center text-muted mt-4 mb-0 fs-13">
                {{ __('¿No tienes cuenta?') }}
                <a href="{{ route('register') }}" class="text-primary fw-semibold">{{ __('Regístrate') }}</a>
            </p>
        @endif
    </form>
</x-guest-layout>
