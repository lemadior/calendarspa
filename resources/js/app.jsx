import './bootstrap';
import '../css/app.css'; // Необходимо для подключения Tailwind

import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
//import Layout from '@/Layouts/Layout'; // На начальном этапе это нужно закомментировать, если не нужны Лейауты

createInertiaApp({
    title: title => `LAREACT | ${title}`, // Это нужно для динимечского изменения титла через компонент Head. Если не нужно - можно отключить.
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.jsx', { eager: true });
        const page = pages[ `./Pages/${name}.jsx` ];

        // page.default.layout = page.default.layout || (page => <Layout children={ page } />); // Это тоже можно отключить, если не нужны Лейауты.

        return page;
    },
    setup ({ el, App, props }) {
        createRoot(el).render(<App { ...props } />);
    },
});
