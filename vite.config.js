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
