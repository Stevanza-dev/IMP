<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'IMP UNNES - Ikatan Mahasiswa Pati' }}</title>
    <link rel="icon" href="{{ asset('images/logonocap.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,400;1,700&display=swap" rel="stylesheet">

    <!-- PWA  -->
    <meta name="theme-color" content="#2563eb"/>
    <link rel="icon" href="{{ asset('pwa/logo128.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('pwa/logo512.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $ogTitle ?? 'IMP UNNES - Ikatan Mahasiswa Pati' }}" />
    <meta property="og:description" content="{{ $ogDescription ?? 'Website resmi Ikatan Mahasiswa Pati Universitas Negeri Semarang' }}" />
    <meta property="og:image" content="{{ $ogImage ?? url('images/og-imp.png') }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    @livewireStyles

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-royal {
            font-family: 'Cinzel', serif;
        }

        .font-serif-italic {
            font-family: 'Playfair Display', serif;
            font-style: italic;
        }

        {{ $styles ?? '' }}
    </style>

    {{ $additionalStyles ?? '' }}
</head>

<body class="{{ $bodyClass ?? 'bg-gray-50 text-gray-800' }}">

    @include('partials.header')

    {{ $slot }}

    @include('partials.footer')
    
    @livewireScripts
    
    <script src="{{ asset('sw.js') }}"></script>
    <script>
        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register("/sw.js").then(
            (registration) => {
                console.log("Service worker registration succeeded:", registration);
            },
            (error) => {
                console.error(`Service worker registration failed: ${error}`);
            },
            );
        } else {
            console.error("Service workers are not supported.");
        }

        window.addEventListener('scroll', function () {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-md');
            } else {
                nav.classList.remove('shadow-md');
            }
        });
    </script>

    {{ $scripts ?? '' }}

</body>

</html>
