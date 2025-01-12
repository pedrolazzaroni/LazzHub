@extends('layouts.app')

@section('title', 'Histórico')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Meu Histórico</h2>

                @if($items->isEmpty())
                    <p class="text-gray-500 text-center py-8">Você ainda não tem itens salvos.</p>
                @else
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($items as $item)
                            <div class="bg-white rounded-lg border shadow-sm hover:shadow-md transition-shadow">
                                <div class="p-5">
                                    <!-- Label to identify content type -->
                                    <div class="mb-2">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            {{ get_class($item) === 'App\Models\Resumo' ?
                                                'bg-blue-100 text-blue-800' :
                                                'bg-green-100 text-green-800' }}">
                                            {{ get_class($item) === 'App\Models\Resumo' ? 'Resumo' : 'Questão' }}
                                        </span>
                                    </div>

                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $item->materia }}</h3>
                                    <p class="text-sm text-gray-600 mb-3">
                                        @if(get_class($item) === 'App\Models\Resumo')
                                            {{ $item->curso }}
                                        @else
                                            Nível: {{ $item->nivel }}
                                        @endif
                                    </p>
                                    <div class="text-xs text-gray-500 mb-4">
                                        Criado em {{ $item->created_at->format('d/m/Y H:i') }}
                                    </div>
                                    <a href="{{ get_class($item) === 'App\Models\Resumo' ?
                                        route('resumo.show', $item->id) :
                                        route('questoes.show', $item->id) }}"
                                        class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
                                        Ver {{ get_class($item) === 'App\Models\Resumo' ? 'resumo' : 'questão' }}
                                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $items->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
