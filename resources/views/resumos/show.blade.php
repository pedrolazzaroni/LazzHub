@extends('layouts.app')

@section('title', 'Resumo - ' . $resumo['materia'])

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 print-up">
                <h1 class="text-2xl font-bold text-gray-900">{{ $resumo['materia'] }}</h1>

                @php
                    $formattedContent = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong><br>', $resumo->content);
                @endphp

                <p class="mt-1 text-sm text-gray-600">Conteúdo: {!! nl2br($formattedContent) !!}</p>
                <p class="text-sm text-gray-500">Nível: {{ ucfirst($resumo['nivel']) }}</p>

                <div class="mt-8 border-t pt-6 flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-4 print-hide justify-center sm:justify-start">
                    <button onclick="window.history.back()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Gerar Novo Resumo
                    </button>
                    <button onclick="copyToClipboard()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Copiar Resumo
                    </button>
                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        Imprimir Resumo
                    </button>
                </div>

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
        const content = document.querySelector('p.mt-1.text-sm.text-gray-600').innerText;
        navigator.clipboard.writeText(content).then(() => {
            showNotification();
        }).catch(err => {
            console.error('Erro ao copiar texto: ', err);
            alert('Não foi possível copiar o texto. Tente novamente.');
        });
    }

    function showNotification() {
        const notification = document.getElementById('notification');
        notification.classList.remove('hidden');
        setTimeout(() => {
            notification.classList.add('hidden');
        }, 500);
    }
</script>
@endpush
@include('layouts.print')
@endsection
