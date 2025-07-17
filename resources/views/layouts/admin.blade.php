<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>
    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="p-4 text-white bg-gray-800">
            <div class="container flex items-center justify-between mx-auto">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">Content Moderation</a>
                    <div class="hidden space-x-4 md:flex">
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">Dashboard</a>
                        <a href="{{ route('admin.moderation-queue') }}" class="px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.moderation-queue') ? 'bg-gray-700' : '' }}">Moderation Queue</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-400">{{ Auth::user()->name }}</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-400 hover:text-white">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        <!-- Page Content -->
        <main class="container px-4 py-6 mx-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">@yield('title', 'Admin Dashboard')</h1>
            </div>
            {{ $slot }}
        </main>
    </div>
    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>