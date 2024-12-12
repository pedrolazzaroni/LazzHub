@extends('layouts.app')

@section('title', 'Resumo - ' . $resumo['materia'])

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">{{ $resumo['materia'] }}</h1>

                @php
                    // Decodifica o JSON e extrai o texto
                    $contentArray = json_decode($resumo['content'], true);
                    $text = $contentArray['candidates'][0]['content']['parts'][0]['text'] ?? 'Conteúdo não disponível.';

                    // Função para converter **texto** em <strong>texto</strong>
                    $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
                @endphp

                <p class="mt-1 text-sm text-gray-600">Conteúdo: {!! nl2br($text) !!}</p>
                <p class="text-sm text-gray-500">Nível: {{ ucfirst($resumo['nivel']) }}</p>

                <!-- Rodapé de Ações no Topo -->
                <div class="mt-8 border-t pt-6 flex justify-between">
                    <div>
                        <button onclick="window.history.back()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Gerar Novo Resumo
                        </button>
                        <button onclick="copyToClipboard()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Copiar Resumo
                        </button>
                    </div>
                </div>

                <!-- Notificação -->
                <div id="notification" class="fixed right-5 top-20 hidden bg-green-500 text-white p-3 rounded-md shadow-md">
                    Resumo copiado para a área de transferência!
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showSaveModal() {
        document.getElementById('saveModal').classList.remove('hidden');
    }

    function hideSaveModal() {
        document.getElementById('saveModal').classList.add('hidden');
    }

    function copyToClipboard() {
        const content = document.querySelector('p.mt-1.text-sm.text-gray-600').innerText; // Seleciona o conteúdo do resumo
        navigator.clipboard.writeText(content).then(() => {
            showNotification(); // Mostra a notificação
        }).catch(err => {
            console.error('Erro ao copiar texto: ', err);
            alert('Não foi possível copiar o texto. Tente novamente.');
        });
    }

    function showNotification() {
        const notification = document.getElementById('notification');
        notification.classList.remove('hidden'); // Mostra a notificação
        setTimeout(() => {
            notification.classList.add('hidden'); // Esconde a notificação após 3 segundos
        }, 500);
    }
</script>
@endpush
@endsection
