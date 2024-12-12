@extends('layouts.app')

@section('title', 'Resultado da Pergunta')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Resultado da Pergunta</h2>

                <div class="mt-4">
                    <h3 class="text-lg font-medium">Sua Pergunta:</h3>
                    <p>{{ request()->input('pergunta') }}</p>
                </div>

                <div class="mt-4">
                    <h3 class="text-lg font-medium">Resposta:</h3>
                    <p>{{ $resultado['contents'][0]['parts'][0]['text'] ?? 'Resposta não disponível.' }}</p>
                </div>

                <div class="flex justify-end mt-4">
                    <a href="{{ route('pergunta.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Fazer Outra Pergunta
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
