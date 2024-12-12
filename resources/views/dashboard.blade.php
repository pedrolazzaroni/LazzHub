@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Card Resumo -->
            <div class="bg-indigo-600 overflow-hidden shadow-lg sm:rounded-lg transition-transform transform hover:scale-105 duration-300">
                <div class="p-6 flex items-center">
                    <div class="icon-bg p-3 rounded-full">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-semibold text-white">Resumo</h2>
                        <p class="mt-2 text-gray-200">Crie e visualize resumos de provas.</p>
                        <a href="{{ route('resumo.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-white text-indigo-600 rounded-md hover:bg-gray-200 transition duration-300">
                            Ir para Resumo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Faça uma Pergunta -->
            <div class="bg-indigo-600 overflow-hidden shadow-lg sm:rounded-lg transition-transform transform hover:scale-105 duration-300">
                <div class="p-6 flex items-center">
                    <div class="icon-bg p-3 rounded-full">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 2a9 9 0 100 18 9 9 0 000-18zm1 13h-2v-2h2v2zm0-4h-2V7h2v4z"/>
                            <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" fill="none"/>
                            <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-semibold text-white">Faça uma Pergunta</h2>
                        <p class="mt-2 text-gray-200">Pergunte sobre qualquer assunto.</p>
                        <a href="{{ route('pergunta.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-white text-indigo-600 rounded-md hover:bg-gray-200 transition duration-300">
                            Ir para Pergunta
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Em Construção 1 -->
            <div class="bg-indigo-600 overflow-hidden shadow-lg sm:rounded-lg transition-transform transform hover:scale-105 duration-300">
                <div class="p-6 text-center">
                    <h2 class="text-lg font-semibold text-white">Em Construção</h2>
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
            </div>

            <!-- Card Em Construção 2 -->
            <div class="bg-indigo-600 overflow-hidden shadow-lg sm:rounded-lg transition-transform transform hover:scale-105 duration-300">
                <div class="p-6 text-center">
                    <h2 class="text-lg font-semibold text-white">Em Construção</h2>
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
