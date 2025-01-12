@extends('layouts.app')

@section('title', 'Visualizar Questão(s)')

@push('styles')
<style>
    @media print {
        .print-hide {
            display: none !important; /* Force hide elements with print-hide class */
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
        nav > div > div > div:last-child {
            display: none !important; /* Force hide navigation items */
        }
    }
</style>
@endpush

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 ">
        @foreach($questoes as $questao)
            <div class="bg-white shadow-lg sm:rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 print-up">Questão #{{ $questao->id }}</h2>
                @if($questao->gemini_response)
                    <div class="mb-4 ">
                        {{-- Questão --}}
                        @php
                            $formattedResponse = preg_replace('/\*\*(.*?)\*\*/', '<br><strong>$1</strong><br>', $questao->gemini_response);
                        @endphp
                        <p class="text-gray-600 mt-[-30px]">{!! $formattedResponse !!}</p>
                    </div>
                @else
                    <div class="mb-4">
                        {{-- Questão não disponível --}}
                        <p class="text-gray-700"><strong>Questão:</strong> <span class="text-red-500">Não disponível.</span></p>
                    </div>
                @endif

                <!-- Rodapé de Ações no Topo -->
                <div class="mt-8 border-t pt-6 flex justify-between print-hide">
                    <div>
                        <a href="{{ route('questoes.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Criar Nova Questão
                        </a>
                        <button onclick="copyToClipboard({{ $questao->id }})"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Copiar Questão
                        </button>
                        <button onclick="window.print()"
                            class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Imprimir Questão
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function copyToClipboard(id) {
        const questao = @json($questoes->keyBy('id'));
        const selectedQuestao = questao[id];

        const conteudo = `Questão: ${selectedQuestao.gemini_response}`;

        navigator.clipboard.writeText(conteudo).then(() => {
            alert('Questão copiada para a área de transferência!');
        }).catch(err => {
            alert('Erro ao copiar a questão.');
        });
    }
</script>

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
@endsection
