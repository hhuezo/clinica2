<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-nav-layout="vertical" data-theme-mode="light"
    data-header-styles="light" data-menu-styles="dark">

<head>
    @include('layouts.partials.xintra-head', ['authPage' => false, 'title' => $title ?? config('app.name')])
</head>

<body>
    <div class="page">
        <div class="main-content app-content">
            <div class="container-fluid">
                @include('layouts.navigation')

                @isset($header)
                    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                        {{ $header }}
                    </div>
                @endisset

                {{ $slot }}
            </div>
        </div>
    </div>

    @include('layouts.partials.xintra-scripts')
</body>

</html>
