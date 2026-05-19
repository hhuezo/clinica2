<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? config('app.name', 'Clínica') }}</title>

<link rel="icon" href="{{ asset('assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

@if ($authPage ?? false)
    <script src="{{ asset('assets/js/authentication-main.js') }}"></script>
@else
    <script src="{{ asset('assets/js/main.js') }}"></script>
@endif

<link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">

@if ($authPage ?? false)
    <link href="{{ asset('assets/css/auth-login.css') }}" rel="stylesheet">
@endif

@stack('styles')
