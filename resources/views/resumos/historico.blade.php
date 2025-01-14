@extends('layouts.app')

@section('title', 'Histórico')

@section('content')
<div class="py-12 overflow-hidden">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 100ms">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
            <div class="p-6 bg-blue-50 border-b border-gray-300 opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 300ms">
                <h2 class="text-2xl font-semibold text-gray-700 mb-6 opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 400ms" id="title">
                    Meu Histórico
                </h2>

                @if($items->isEmpty())
                    <p class="text-gray-500 text-center py-8">Você ainda não tem itens salvos.</p>
                @else
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 500ms">
                        @foreach($items as $item)
                            @if($item instanceof \Illuminate\Support\Collection)
                                @if($item->first() instanceof \App\Models\Questao)
                                    <a href="{{ route('questoes.show', $item->pluck('id')->implode(',')) }}" class="relative bg-indigo-500 rounded-lg border shadow-lg hover:shadow-xl transition-transform transform hover:scale-105">
                                        <div class="p-5">
                                            <div class="flex justify-between items-center mb-4">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Questão
                                                </span>
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-white text-indigo-500">
                                                    {{ $item->count() }}
                                                </span>
                                            </div>
                                            <div class="mb-4">
                                                <h3 class="text-lg font-semibold text-white mb-2">{{ $item->first()->materia }}</h3>
                                                <p class="text-sm text-gray-200 mb-3">
                                                    Nível: {{ $item->first()->nivel }}
                                                </p>
                                                <div class="text-xs text-gray-300 mb-4">
                                                    Criado em {{ $item->first()->created_at->format('d/m/Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @elseif($item->first() instanceof \App\Models\Pergunta)
                                    <a href="{{ route('pergunta.resultado', $item->pluck('id')->implode(',')) }}" class="relative bg-indigo-500 rounded-lg border shadow-lg hover:shadow-xl transition-transform transform hover:scale-105">
                                        <div class="p-5">
                                            <div class="flex justify-between items-center mb-4">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pergunta
                                                </span>
                                            </div>
                                            <div class="mb-4">
                                                <h3 class="text-lg font-semibold text-white mb-2">{{ $item->first()->titulo }}</h3>
                                                <div class="text-xs text-gray-300 mb-4">
                                                    Criado em {{ $item->first()->created_at->format('d/m/Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('resumo.show', $item->id) }}" class="relative bg-indigo-500 rounded-lg border shadow-lg hover:shadow-xl transition-transform transform hover:scale-105">
                                    <div class="p-5">
                                        <div class="flex justify-between items-center mb-4">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Resumo
                                            </span>
                                        </div>
                                        <div class="mb-4">
                                            <h3 class="text-lg font-semibold text-white mb-2">{{ $item->materia }}</h3>
                                            <p class="text-sm text-gray-200 mb-3">
                                                {{ $item->curso }}
                                            </p>
                                            <div class="text-xs text-gray-300 mb-4">
                                                Criado em {{ $item->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>

                    <div class="mt-6 opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 700ms">
                        @if ($items->hasPages())
                            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
                                @if ($items->onFirstPage())
                                    <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded-l-md cursor-not-allowed">
                                        Anterior
                                    </span>
                                @else
                                    <a href="{{ $items->previousPageUrl() }}"
                                       class="px-3 py-1 bg-indigo-600 text-white rounded-l-md hover:bg-indigo-700 transition duration-150 ease-in-out">
                                        Anterior
                                    </a>
                                @endif
                                <div class="flex items-center">
                                    @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                                        @if ($page == $items->currentPage())
                                            <span class="px-3 py-1 bg-indigo-600 text-white border-t border-b">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}"
                                               class="px-3 py-1 bg-white text-indigo-600 border-t border-b hover:bg-indigo-50 transition duration-150 ease-in-out">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                                @if ($items->hasMorePages())
                                    <a href="{{ $items->nextPageUrl() }}"
                                       class="px-3 py-1 bg-indigo-600 text-white rounded-r-md hover:bg-indigo-700 transition duration-150 ease-in-out">
                                        Próxima
                                    </a>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded-r-md cursor-not-allowed">
                                        Próxima
                                    </span>
                                @endif
                            </nav>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            document.querySelectorAll('.opacity-0').forEach(el => {
                el.classList.remove('opacity-0', 'translate-y-4');
            });
        }, 100);
    });
</script>
@endsection
