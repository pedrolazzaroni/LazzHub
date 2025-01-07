@extends('layouts.app')

@section('title', 'Bem-vindo')

@section('content')
<div class="relative bg-indigo-600">
    <div class="max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl md:text-6xl">
                Bem-vindo ao {{ config('app.name') }}
            </h1>
            <p class="mt-3 max-w-md mx-auto text-base text-indigo-200 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                Sua plataforma de estudos inteligente com IA
            </p>
            <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                @guest
                    <div class="rounded-md shadow">
                        <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10 transition duration-300 ease-in-out transform hover:scale-105">
                            Começar Agora
                        </a>
                    </div>
                @else
                    <div class="rounded-md shadow">
                        <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10 transition duration-300 ease-in-out transform hover:scale-105">
                            Ir para Dashboard
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Seção de recursos -->
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
            <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Recursos</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Uma melhor maneira de aprender
            </p>
        </div>

        <div class="mt-10">
            <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                <!-- Gerador de Questões -->
                <a href="{{ route('questoes.create') }}" class="relative transition-transform transform hover:scale-105 duration-300 border rounded-lg shadow-lg p-6 bg-white hover:bg-indigo-50">
                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div class="ml-16">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Gerador de Questões</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Crie questões personalizadas para seus estudos
                        </p>
                    </div>
                </a>

                <!-- Recurso 2: Resumos Inteligentes -->
                <a href="{{ route('resumo.create') }}" class="relative transition-transform transform hover:scale-105 duration-300 border rounded-lg shadow-lg p-6 bg-white hover:bg-indigo-50">
                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <div class="ml-16">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Resumos Inteligentes</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Resumos gerados automaticamente para facilitar seu aprendizado
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
