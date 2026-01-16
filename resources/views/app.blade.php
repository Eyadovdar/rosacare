<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        {{-- Local font hosting: Alexandria and Tasees fonts per RosaCare Branding Book --}}
        <style>
            /* Alexandria font: Primary font for both Arabic and English (weights: 100-700) */
            @font-face {
                font-family: 'Alexandria';
                font-style: normal;
                font-weight: 100;
                font-display: swap;
                src: url('/fonts/alexandria/Alexandria-Thin.ttf') format('truetype');
            }
            @font-face {
                font-family: 'Alexandria';
                font-style: normal;
                font-weight: 200;
                font-display: swap;
                src: url('/fonts/alexandria/Alexandria-ExtraLight.ttf') format('truetype');
            }
            @font-face {
                font-family: 'Alexandria';
                font-style: normal;
                font-weight: 300;
                font-display: swap;
                src: url('/fonts/alexandria/Alexandria-Light.ttf') format('truetype');
            }
            @font-face {
                font-family: 'Alexandria';
                font-style: normal;
                font-weight: 400;
                font-display: swap;
                src: url('/fonts/alexandria/Alexandria-Regular.ttf') format('truetype');
            }
            @font-face {
                font-family: 'Alexandria';
                font-style: normal;
                font-weight: 500;
                font-display: swap;
                src: url('/fonts/alexandria/Alexandria-Medium.ttf') format('truetype');
            }
            @font-face {
                font-family: 'Alexandria';
                font-style: normal;
                font-weight: 600;
                font-display: swap;
                src: url('/fonts/alexandria/Alexandria-SemiBold.ttf') format('truetype');
            }
            @font-face {
                font-family: 'Alexandria';
                font-style: normal;
                font-weight: 700;
                font-display: swap;
                src: url('/fonts/alexandria/Alexandria-Bold.ttf') format('truetype');
            }
            
            /* Tasees Bold: Display font for special headings/logos */
            @font-face {
                font-family: 'Tasees';
                font-weight: bold;
                font-display: swap;
                src: url('/fonts/Tasees-Bold.woff2') format('woff2'),
                     url('/fonts/Tasees-Bold.woff') format('woff'),
                     url('/fonts/Tasees-Bold.ttf') format('truetype');
            }
        </style>

        @viteReactRefresh
        @vite(['resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
        
        {{-- Preloader will be rendered by React --}}
        <div id="preloader-root"></div>
</html>
