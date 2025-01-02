@extends('layouts.app')

@section('title', 'Visualizar Questão')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Questão</h2>
            <div class="mb-4">
                <p class="text-gray-700"><strong>Conteúdo:</strong></p>
                <p class="text-gray-600">{{ $questao->conteudo }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700"><strong>Nível de Dificuldade:</strong> {{ $questao->nivel }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700"><strong>Matéria:</strong> {{ $questao->materia }}</p>
            </div>
            <!-- Exibir a resposta do Gemini -->
            <div class="mb-4">
                <p class="text-gray-700"><strong>Resposta do Gemini:</strong></p>
                <p class="text-gray-600">{{ $questao->gemini_response }}</p>
            </div>
            <div class="flex space-x-4">
                <button onclick="window.print()"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    Imprimir
                </button>
                <button onclick="copyToClipboard()"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                    Copiar para Área de Transferência
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyToClipboard() {
        const conteudo = `Questão: {{ $questao->conteudo }}
Nível de Dificuldade: {{ $questao->nivel }}
Matéria: {{ $questao->materia }}
Resposta do Gemini: {{ $questao->gemini_response }}`;

        navigator.clipboard.writeText(conteudo).then(() => {
            alert('Questão copiada para a área de transferência!');
        }).catch(err => {
            alert('Erro ao copiar a questão.');
        });
    }
</script>
@endpush
@endsection
