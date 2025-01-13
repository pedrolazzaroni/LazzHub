@extends('layouts.app')

@section('title', 'Resultado da Pergunta')

@section('content')
<style>
    @media print {
        .print-hide {
            display: none;
        }
        .header {
            box-shadow: none;
            background-color: #6f42c1;
            color: white;
            text-align: center;
        }
        .header h1 {
            margin: 0;
        }
        .bg-white {
            box-shadow: none;
            border: none;
        }
        .dashboard-buttons {
            display: none;
        }
        .print-up {
            margin-top: -20px;
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
                    $pergunta->descricao = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $pergunta->descricao);
                    $text = nl2br($pergunta->descricao);
                    @endphp
                    <p>{!! $text !!}</p>

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
        const content = document.querySelector('p').innerText;
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
        }, 3000);
    }
</script>
@endpush
@endsection
