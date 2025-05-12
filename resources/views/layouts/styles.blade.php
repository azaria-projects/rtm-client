@push('styles')
    @vite([
        'public/themes/adminlte4/css/adminlte.min.css',
        'public/dependancies/select2/css/select2.min.css',

        'resources/css/app.css',
        'resources/css/sidebar.css',
        'resources/css/navbar.css',
        'resources/css/footer.css',
        'resources/css/components/forms.css',
        'resources/css/components/cards.css',
        'resources/css/components/table.css',
        'resources/css/components/toast.css',
        'resources/css/components/select.css',
        'resources/css/components/buttons.css',

        'public/icons/tabler/tabler-icons-filled.min.css',
        'public/icons/tabler/tabler-icons-outline.min.css',
        'public/icons/tabler/tabler-icons.min.css',
    ])
@endpush
