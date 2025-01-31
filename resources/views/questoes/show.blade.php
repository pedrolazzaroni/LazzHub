@extends('layouts.app')

@section('title', 'Visualizar Questão(s)')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg sm:rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 print-up">Questões</h2>

            <div class="space-y-6" id="questoes-container">
                @foreach($questoes as $index => $questao)
                    <div class="p-4 bg-gray-50 rounded-lg shadow-sm questao-item">
                        <div class="mb-2">
                            <span class="text-sm text-gray-500">Questão {{ $index + 1 }}</span>
                        </div>
                        @if($questao->gemini_response)
                            @php
                                $formattedResponse = preg_replace('/\*\*(.*?)\*\*/', '<strong class="text-gray-800">$1</strong>', $questao->gemini_response);
                                $formattedResponse = nl2br($formattedResponse);
                            @endphp
                            <div class="prose max-w-none text-gray-600 questao-content">
                                {!! $formattedResponse !!}
                            </div>
                        @else
                            <p class="text-gray-700"><strong>Questão:</strong> <span class="text-red-500">Não disponível.</span></p>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-8 border-t pt-6 flex flex-wrap gap-4 print-hide justify-center sm:justify-start">
                <a href="{{ route('questoes.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white transition-colors duration-150 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Gerar Nova Questão
                </a>
                <button onclick="copyToClipboard()"
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white transition-colors duration-150 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                    </svg>
                    Copiar Questão
                </button>
                <button onclick="window.print()"
                        class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-white transition-colors duration-150 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Imprimir Questão
                </button>
            </div>
        </div>
    </div>
</div>

<div id="notification" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-full opacity-0 transition-all duration-300 hidden">
    Conteúdo copiado com sucesso!
</div>

<script>
    function showNotification() {
        const notification = document.getElementById('notification');
        notification.classList.remove('hidden', 'translate-y-full', 'opacity-0');
        setTimeout(() => {
            notification.classList.add('translate-y-full', 'opacity-0');
            setTimeout(() => notification.classList.add('hidden'), 300);
        }, 2000);
    }

    function copyToClipboard() {
        const content = Array.from(document.querySelectorAll('.questao-content'))
            .map(el => el.innerText.trim())
            .join('\n\n');

        navigator.clipboard.writeText(content).then(() => {
            showNotification();
        }).catch(err => {
            console.error('Erro ao copiar texto: ', err);
            alert('Não foi possível copiar o texto. Tente novamente.');
        });
    }
</script>

<style>
    @media print {
        .print-hide {
            display: none !important;
        }
        .questao-item {
            break-inside: avoid;
            page-break-inside: avoid;
        }
    }
</style>

@include('layouts.print')
@endsection
