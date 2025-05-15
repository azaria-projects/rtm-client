import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

async function getConfig() {
    const paths = [
        'resources/js/app.js',
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
        'resources/css/components/notification.css',

        'public/themes/adminlte4/css/adminlte.min.css',
        'public/themes/adminlte4/js/adminlte.min.js',

        'resources/dep/select2/css/select2.min.css',
        'resources/dep/select2/js/select2.min.js',

        'public/icons/tabler/tabler-icons-filled.min.css',
        'public/icons/tabler/tabler-icons-outline.min.css',
        'public/icons/tabler/tabler-icons.min.css',
    ];

    return defineConfig({
        plugins: [
            laravel({
                input: paths,
                refresh: true,
            })
        ]
    });
};

export default getConfig();
