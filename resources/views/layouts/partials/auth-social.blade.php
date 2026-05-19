@php
    $providers = [
        'google' => 'Google',
        'facebook' => 'Facebook',
    ];
@endphp

<div class="d-grid gap-2">
    @foreach ($providers as $provider => $label)
        <a href="{{ route('social.redirect', $provider) }}" class="btn btn-light btn-wave">
            {{ __('Continuar con :provider', ['provider' => $label]) }}
        </a>
    @endforeach
</div>

<div class="text-center my-3 authentication-barrier">
    <span class="text-muted fs-12">{{ __('o') }}</span>
</div>
