<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.metadata')

    @include('layouts.styles')

    @stack('styles')

    @stack('scripts-head')
</head>
<body class="layout-fixed sidebar-expand-lg sidebar-mini main-background" data-bs-theme="dark">
    <div class="app-wrapper">
        @include('layouts.navbar')

        @include('layouts.sidebar')

        {{-- <main class="app-main">
            @include('layouts.header')

            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </main> --}}

        <main class="app-main">
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>

    @include('layouts.scripts')

    @stack('scripts-body')
</body>
</html>
