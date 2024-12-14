@extends('layouts.app')

@section('title', 'Resultado da Pergunta')

@section('content')
<style>
    @media print {
        .print-hide {
            display: none; /* Oculta os elementos com a classe 'print-hide' durante a impressão */
        }
        .header {
            box-shadow: none; /* Remove a sombra do cabeçalho */
            background-color: #6f42c1; /* Mantém a cor de fundo */
            color: white; /* Mantém a cor do texto */
            text-align: center; /* Centraliza o texto do cabeçalho */
        }
        .header h1 {
            margin: 0; /* Remove margens do título */
        }
        .bg-white {
            box-shadow: none; /* Remove o efeito de card do conteúdo */
            border: none; /* Remove a borda do card */
        }
        /* Oculta os botões de dashboard, histórico e sair */
        .dashboard-buttons {
            display: none; /* Adicione a classe 'dashboard-buttons' aos botões que você deseja ocultar */
        }
        .print-up {
            margin-top: -20px; /* Adiciona margem superior de 100px */
        }
    }
</style>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 print-up">
                <h1 class="text-2xl font-bold text-gray-900">{{ $pergunta->titulo }}</h1>

                <div class="mt-4">
                    <h3 class="text-lg font-medium">Resposta:</h3>
                    @php
                    // Função para converter **texto** em <strong>texto</strong>
                    $pergunta->descricao = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $pergunta->descricao);
                    $text = nl2br($pergunta->descricao); // Converte quebras de linha
                    @endphp
                    <p>{!! $text !!}</p>

                <!-- Rodapé de Ações no Topo -->
                <div class="mt-8 border-t pt-6 flex justify-between print-hide">
                    <div>
                        <button onclick="window.history.back()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Fazer Outra Pergunta
                        </button>
                        <button onclick="copyToClipboard()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Copiar Resposta
                        </button>
                        <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Imprimir Resposta
                        </button>
                    </div>
                </div>

                <!-- Notificação -->
                <div id="notification" class="fixed right-5 top-20 hidden bg-green-500 text-white p-3 rounded-md shadow-md">
                    Resposta copiada para a área de transferência!
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyToClipboard() {
        const content = document.querySelector('p').innerText; // Seleciona o conteúdo da resposta
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
        }, 3000);
    }
</script>
@endpush
@endsection
