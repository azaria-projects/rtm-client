<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.metadata')

    @include('layouts.styles')

    @stack('styles')

    @stack('scripts-head')
</head>
<body class="login-page">
    <div class="app-wrapper">
        <main class="app-main align-self-center my-0 py-0">
            @yield('content')
        </main>
    </div>

    @include('layouts.auth.scripts')

    @stack('scripts-body')
</body>
</html>
