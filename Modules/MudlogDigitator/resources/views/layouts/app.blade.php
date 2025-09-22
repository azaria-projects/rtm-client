<!DOCTYPE html>
<html lang="en">
<head>
    @include('mudlogdigitator::layouts.metadata')

    @include('mudlogdigitator::layouts.styles')

    @stack('styles')

    @stack('scripts-head')
</head>
<body class="layout-fixed sidebar-expand-lg sidebar-mini" data-bs-theme="dark">
    <div class="app-wrapper">
        @include('mudlogdigitator::layouts.navbar')

        <main class="app-main">
            @include('components.loading')
            
            @yield('content')
        </main>

        @include('mudlogdigitator::layouts.footer')
    </div>

    @include('mudlogdigitator::layouts.scripts')

    @stack('scripts-body')
</body>
</html>
