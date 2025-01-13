<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <div id="notification" class="fixed top-4 right-0 transform translate-x-full transition-all duration-300 ease-in-out z-50">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span id="notificationMessage"></span>
            </div>
        </div>
    </div>

    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600 logo">
                            {{ config('app.name') }}
                        </a>
                    </div>
                </div>

                <div class="flex items-center no-print">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 dashboard-buttons">Dashboard</a>
                        <a href="{{ route('resumo.historico') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 dashboard-buttons">Histórico</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-indigo-600 px-3 py-2 dashboard-buttons">Sair</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Login</a>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Registro</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.
            </p>
        </div>
    </footer>

    @stack('scripts')

    <script>
        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            const messageElement = document.getElementById('notificationMessage');

            messageElement.textContent = message;

            notification.querySelector('div').className = 'p-4 rounded shadow-lg flex items-center';

            if (type === 'success') {
                notification.querySelector('div').classList.add('bg-green-100', 'border-l-4', 'border-green-500', 'text-green-700');
            } else if (type === 'error') {
                notification.querySelector('div').classList.add('bg-red-100', 'border-l-4', 'border-red-500', 'text-red-700');
            }

            notification.classList.remove('translate-x-full');

            setTimeout(() => {
                notification.classList.add('translate-x-full');
            }, 3000);
        }
    </script>

    @push('styles')
    <style>
        @media print {
            .no-print {
                display: none;
            }

            footer {
                display: none;
            }

            .logo {
                display: block;
            }

            main {
                margin: 0;
                padding: 0;
            }
            .bg-white {
                box-shadow: none;
                border: none;
            }
        }
    </style>
    @endpush
</body>
</html>
