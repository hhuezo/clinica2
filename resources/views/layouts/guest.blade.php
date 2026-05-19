<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-nav-layout="vertical" data-theme-mode="light"
    data-header-styles="light" data-menu-styles="dark">

<head>
    @include('layouts.partials.xintra-head', ['authPage' => true, 'title' => $title ?? config('app.name')])
</head>

<body class="authentication authentication-basic authentication-background">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 py-4">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="card custom-card shadow-none border-0">
                    <div class="card-body p-5">
                        <div class="mb-4 text-center">
                            @include('layouts.partials.xintra-brand')
                        </div>

                        @isset($heading)
                            <p class="h5 fw-semibold mb-1">{{ $heading }}</p>
                        @endisset

                        @isset($subheading)
                            <p class="mb-4 text-muted op-7 fw-normal">{{ $subheading }}</p>
                        @endisset

                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.xintra-scripts')
</body>

</html>
