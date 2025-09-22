@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />

    <link rel="stylesheet" href="{{ asset('themes/adminlte4/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dependancies/select2/css/select2.min.css') }}">

    @vite([
        'resources/css/app.css',
        'resources/css/navbar.css',
        'resources/css/footer.css',
        'resources/css/components/forms.css',
        'resources/css/components/cards.css',
        'resources/css/components/toast.css',
        'resources/css/components/select.css',
        'resources/css/components/buttons.css',
    ])
@endpush
