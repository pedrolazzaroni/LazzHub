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
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 dashboard-buttons {{ request()->routeIs('dashboard') ? 'text-indigo-600 ' : '' }}">Dashboard</a>
                        <a href="{{ route('resumo.historico') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 dashboard-buttons {{ request()->routeIs('resumo.historico') ? 'text-indigo-600 ' : '' }}">Histórico</a>
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
            <p class="text-center text-gray-500 mt-2 flex items-center justify-center">
                Desenvolvido por Pedro Lazzaroni
                <a href="https://github.com/pedrolazzaroni" class="ml-2 text-indigo-600 hover:text-indigo-800">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C5.373 0 0 5.373 0 12c0 5.303 3.438 9.8 8.205 11.387.6.111.82-.261.82-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.757-1.333-1.757-1.089-.744.083-.729.083-.729 1.205.084 1.838 1.237 1.838 1.237 1.07 1.835 2.809 1.305 3.495.998.108-.775.418-1.305.762-1.605-2.665-.305-5.466-1.333-5.466-5.93 0-1.31.467-2.381 1.235-3.221-.123-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.29-1.552 3.297-1.23 3.297-1.23.654 1.653.242 2.873.12 3.176.77.84 1.233 1.911 1.233 3.221 0 4.61-2.804 5.623-5.475 5.92.43.372.823 1.102.823 2.222v3.293c0 .319.218.694.825.576C20.565 21.796 24 17.299 24 12c0-6.627-5.373-12-12-12z"/>
                    </svg>
                </a>
                <a href="https://www.linkedin.com/in/pedrolazzaroni" class="ml-2 text-indigo-600 hover:text-indigo-800">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-10h3v10zm-1.5-11.268c-.966 0-1.75-.784-1.75-1.75s.784-1.75 1.75-1.75 1.75.784 1.75 1.75-.784 1.75-1.75 1.75zm13.5 11.268h-3v-5.5c0-1.378-1.122-2.5-2.5-2.5s-2.5 1.122-2.5 2.5v5.5h-3v-10h3v1.268c.878-.878 2.122-1.268 3.5-1.268 2.481 0 4.5 2.019 4.5 4.5v5.5z"/>
                    </svg>
                </a>
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
