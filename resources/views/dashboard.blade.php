@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-8 opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 100ms">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg sm:rounded-lg mb-4 p-4">
            <h3 class="text-lg font-semibold text-indigo-600 mb-4 text-center">Para Estudantes</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <a href="{{ route('resumo.create') }}" class="bg-indigo-600 overflow-hidden shadow-lg sm:rounded-lg transition-transform transform hover:scale-105 duration-300 flex flex-col items-center block">
                    <div class="p-4 flex flex-col items-center">
                        <div class="icon-bg p-2 rounded-full flex items-center justify-center">
                            <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            </svg>
                        </div>
                        <div class="ml-0 mt-2 text-center">
                            <h2 class="text-md font-semibold text-white">Resumo</h2>
                            <p class="mt-1 text-gray-200">Crie resumos sobre qualquer matéria</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('pergunta.create') }}" class="bg-indigo-600 overflow-hidden shadow-lg sm:rounded-lg transition-transform transform hover:scale-105 duration-300 flex flex-col items-center block">
                    <div class="p-4 flex flex-col items-center">
                        <div class="icon-bg p-2 rounded-full flex items-center justify-center">
                            <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 2a9 9 0 100 18 9 9 0 000-18zm1 13h-2v-2h2v2zm0-4h-2V7h2v4z"/>
                                <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" fill="none"/>
                                <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2" />
                            </svg>
                        </div>
                        <div class="ml-0 mt-2 text-center">
                            <h2 class="text-md font-semibold text-white">Faça uma Pergunta</h2>
                            <p class="mt-1 text-gray-200">Pergunte sobre qualquer assunto</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white shadow-lg sm:rounded-lg p-4">
                <h3 class="text-lg font-semibold text-indigo-600 mb-4 text-center">Para Professores</h3>
                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('questoes.create') }}" class="bg-indigo-600 overflow-hidden shadow-lg sm:rounded-lg transition-transform transform hover:scale-105 duration-300 flex flex-col items-center block">
                        <div class="p-4 flex flex-col items-center">
                            <div class="icon-bg p-2 rounded-full flex items-center justify-center">
                                <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div class="ml-0 mt-2 text-center">
                                <h2 class="text-md font-semibold text-white">Criar Questão</h2>
                                <p class="mt-1 text-gray-200">Crie questões para suas provas</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="bg-white shadow-lg sm:rounded-lg p-4">
                <h3 class="text-lg font-semibold text-indigo-600 mb-4 text-center">Histórico</h3>
                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('resumo.historico') }}" class="bg-indigo-600 overflow-hidden shadow-lg sm:rounded-lg transition-transform transform hover:scale-105 duration-300 flex flex-col items-center block">
                        <div class="p-4 flex flex-col items-center">
                            <div class="icon-bg p-2 rounded-full flex items-center justify-center">
                                <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-0 mt-2 text-center">
                                <h2 class="text-md font-semibold text-white">Histórico</h2>
                                <p class="mt-1 text-gray-200">Veja o histórico de suas atividades</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        document.querySelectorAll('.opacity-0').forEach(el => {
            el.classList.remove('opacity-0', 'translate-y-4');
        });
    }, 100);
});
</script>
@endpush
@endsection
