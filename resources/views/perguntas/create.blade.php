@extends('layouts.app')

@section('title', 'Fazer Pergunta')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Faça sua Pergunta</h2>

                <form action="{{ route('pergunta.ask') }}" method="POST">
                    @csrf
                    <div>
                        <label for="pergunta" class="block text-sm font-medium text-gray-700">Digite sua pergunta:</label>
                        <input type="text" name="pergunta" id="pergunta" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Gerar Resposta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
