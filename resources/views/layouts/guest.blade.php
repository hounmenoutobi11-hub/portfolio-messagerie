<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" href="/icon-192.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 py-10 relative overflow-hidden"
        style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);">

        <!-- Décor lumineux en arrière-plan -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-600 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-600 rounded-full opacity-20 blur-3xl"></div>

        <div class="relative z-10 mb-8 text-center">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur border border-white/20 mb-3">
                <span class="text-2xl font-bold text-white">{HTJ}</span>
            </div>
            <p class="text-slate-400 text-sm tracking-wide uppercase">Portfolio Messagerie</p>
        </div>

        <div
            class="relative z-10 w-full sm:max-w-md px-8 py-9 bg-white shadow-2xl overflow-hidden rounded-2xl border border-slate-100">
            {{ $slot }}
        </div>

        <p class="relative z-10 mt-6 text-slate-500 text-xs">
            © {{ date('Y') }} John James Hounmenou
        </p>
    </div>
</body>

</html>
