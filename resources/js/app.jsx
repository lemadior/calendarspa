import './bootstrap';
import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import { useRoute } from '../../vendor/tightenco/ziggy';
import Layout from '@/Layouts/Layout';

const route = useRoute();

createInertiaApp({
    title: title => `LAREACT | ${title}`,
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.jsx', { eager: true });
        const page = pages[ `./Pages/${name}.jsx` ];

        page.default.layout = page.default.layout || (page => <Layout children={ page } />);

        return page;
    },
    setup ({ el, App, props }) {
        window.route = route;
        createRoot(el).render(<App { ...props } />);
    },
});
