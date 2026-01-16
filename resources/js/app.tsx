import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import { initializeTheme } from './hooks/use-appearance';
import { Preloader } from './components/rosacare/Preloader';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Render preloader immediately
const preloaderRoot = document.getElementById('preloader-root');
if (preloaderRoot) {
    const preloaderContainer = createRoot(preloaderRoot);
    preloaderContainer.render(
        <StrictMode>
            <Preloader />
        </StrictMode>
    );
}

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.tsx`,
            import.meta.glob('./pages/**/*.tsx'),
        ),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(
            <StrictMode>
                <App {...props} />
            </StrictMode>,
        );
    },
    progress: {
        color: '#e72177', // Brandbook Primary Rose color
    },
});

// This will set light / dark mode on load...
initializeTheme();
