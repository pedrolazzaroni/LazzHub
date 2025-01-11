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
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        @foreach($questoes as $questao)
            <div class="bg-white shadow-lg sm:rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Questão #{{ $questao->id }}</h2>
                @if($questao->gemini_response)
                    <div class="mb-4">
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
                <div class="flex space-x-4 no-print">
                    <button onclick="window.print()"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                        Imprimir
                    </button>
                    <button onclick="copyToClipboard({{ $questao->id }})"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                        Copiar Questão
                    </button>
                </div>
            </div>
        @endforeach

        <!-- Botão de Criar Outra Questão -->
        <div class="mt-6 flex justify-center print-hide">
            <a href="{{ route('questoes.create') }}"
                class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white transition-all duration-300 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Criar Outra Questão
            </a>
        </div>
    </div>
</div>

@push('scripts')
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
@endpush

@push('styles')
<style>
    @media print {
        /* Removed the header hiding to ensure the logo remains visible */
        /* header {
            display: none;
        } */

        .no-print {
            display: none; /* Oculta os elementos com a classe 'no-print' durante a impressão */
        }

        /* Optional: Adjust margins or other styles for print */
        body {
            margin: 0;
            padding: 0;
        }

        .py-12, .max-w-6xl, .mx-auto, .sm\:px-6, .lg\:px-8 {
            margin: 0;
            padding: 0;
        }

        .bg-white {
            background: none;
            box-shadow: none;
        }
    }
</style>
@endpush
@endsection
