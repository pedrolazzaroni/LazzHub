@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-8"> <!-- Reduced padding from py-12 to py-8 -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Para Estudantes -->
        <div class="bg-white shadow-lg sm:rounded-lg mb-4 p-4"> <!-- Reduced margin-bottom from mb-6 to mb-4 -->
            <h3 class="text-lg font-semibold text-indigo-600 mb-4 text-center">Para Estudantes</h3> <!-- Reduced font size from text-xl to text-lg -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2"> <!-- Reduced gap from gap-6 to gap-4 -->
                <!-- Card Resumo -->
                <a href="{{ route('resumo.create') }}" class="bg-indigo-600 overflow-hidden shadow-lg sm:rounded-lg transition-transform transform hover:scale-105 duration-300 flex flex-col items-center block">
                    <div class="p-4 flex flex-col items-center"> <!-- Reduced padding from p-6 to p-4 -->
                        <div class="icon-bg p-2 rounded-full"> <!-- Reduced padding from p-3 to p-2 -->
                            <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <!-- Reduced icon size from h-12 w-12 to h-10 w-10 -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            </svg>
                        </div>
                        <div class="ml-0 mt-2 text-center"> <!-- Reduced margin-top from mt-4 to mt-2 -->
                            <h2 class="text-md font-semibold text-white">Resumo</h2> <!-- Reduced font size from text-lg to text-md -->
                            <p class="mt-1 text-gray-200">Crie resumos sobre qualquer matéria</p> <!-- Reduced margin-top from mt-2 to mt-1 -->
                        </div>
                    </div>
                </a>

                <!-- Card Faça uma Pergunta -->
                <a href="{{ route('pergunta.create') }}" class="bg-indigo-600 overflow-hidden shadow-lg sm:rounded-lg transition-transform transform hover:scale-105 duration-300 flex flex-col items-center block">
                    <div class="p-4 flex flex-col items-center"> <!-- Reduced padding from p-6 to p-4 -->
                        <div class="icon-bg p-2 rounded-full"> <!-- Reduced padding from p-3 to p-2 -->
                            <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <!-- Reduced icon size from h-12 w-12 to h-10 w-10 -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 2a9 9 0 100 18 9 9 0 000-18zm1 13h-2v-2h2v2zm0-4h-2V7h2v4z"/>
                                <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" fill="none"/>
                                <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2" />
                            </svg>
                        </div>
                        <div class="ml-0 mt-2 text-center"> <!-- Reduced margin-top from mt-4 to mt-2 -->
                            <h2 class="text-md font-semibold text-white">Faça uma Pergunta</h2> <!-- Reduced font size from text-lg to text-md -->
                            <p class="mt-1 text-gray-200">Pergunte sobre qualquer assunto</p> <!-- Reduced margin-top from mt-2 to mt-1 -->
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Agrupar "Para Professores" e "Histórico" em um grid de 2 colunas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4"> <!-- Reduced gap from gap-6 to gap-4 -->
            <!-- Para Professores -->
            <div class="bg-white shadow-lg sm:rounded-lg p-4">
                <h3 class="text-lg font-semibold text-indigo-600 mb-4 text-center">Para Professores</h3> <!-- Reduced font size from text-xl to text-lg -->
                <div class="grid grid-cols-1 gap-4"> <!-- Reduced gap from gap-6 to gap-4 -->
                    <!-- Card Criar Questão -->
                    <a href="{{ route('questoes.create') }}" class="bg-indigo-600 overflow-hidden shadow-lg sm:rounded-lg transition-transform transform hover:scale-105 duration-300 flex flex-col items-center block">
                        <div class="p-4 flex flex-col items-center"> <!-- Reduced padding from p-6 to p-4 -->
                            <div class="icon-bg p-2 rounded-full"> <!-- Reduced padding from p-3 to p-2 -->
                                <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <!-- Reduced icon size from h-12 w-12 to h-10 w-10 -->
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div class="ml-0 mt-2 text-center"> <!-- Reduced margin-top from mt-4 to mt-2 -->
                                <h2 class="text-md font-semibold text-white">Criar Questão</h2> <!-- Reduced font size from text-lg to text-md -->
                                <p class="mt-1 text-gray-200">Crie questões para suas provas</p> <!-- Reduced margin-top from mt-2 to mt-1 -->
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Histórico -->
            <div class="bg-white shadow-lg sm:rounded-lg p-4">
                <h3 class="text-lg font-semibold text-indigo-600 mb-4 text-center">Histórico</h3> <!-- Reduced font size from text-xl to text-lg -->
                <div class="grid grid-cols-1 gap-4"> <!-- Reduced gap from gap-6 to gap-4 -->
                    <!-- Card Histórico -->
                    <a href="{{ route('resumo.historico') }}" class="bg-indigo-600 overflow-hidden shadow-lg sm:rounded-lg transition-transform transform hover:scale-105 duration-300 flex flex-col items-center block">
                        <div class="p-4 flex flex-col items-center"> <!-- Reduced padding from p-6 to p-4 -->
                            <div class="icon-bg p-2 rounded-full"> <!-- Reduced padding from p-3 to p-2 -->
                                <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <!-- Reduced icon size from h-12 w-12 to h-10 w-10 -->
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-0 mt-2 text-center"> <!-- Reduced margin-top from mt-4 to mt-2 -->
                                <h2 class="text-md font-semibold text-white">Histórico</h2> <!-- Reduced font size from text-lg to text-md -->
                                <p class="mt-1 text-gray-200">Veja o histórico de suas atividades</p> <!-- Reduced margin-top from mt-2 to mt-1 -->
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
