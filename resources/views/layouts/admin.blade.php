<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Painel Administrativo') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <x-sidebar class="w-64 bg-gray-800 text-white" />

        <div class="flex flex-col flex-1">
            <!-- Topbar -->
            <header class="bg-white shadow p-4">
                <div class="flex justify-between items-center">
                    <a href="/" wire:navigate>
                        <x-application-logo class="w-10 h-10 fill-current text-gray-500" />
                    </a>
                    <nav class="space-x-4">
                        <a href="{{ route('profile') }}" wire:navigate
                            class="text-gray-700"><b>{{ auth()->user()->name }}</b></a>
                        <a href="#" class="text-gray-700" wire:navigate>Sair</a>
                    </nav>
                </div>
            </header>

            <!-- Conteúdo Principal -->
            <main class="flex-1 p-8">
                <div class="max-w-7xl mx-auto bg-white p-6 shadow rounded-lg">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>

</html>
