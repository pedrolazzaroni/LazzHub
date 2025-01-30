@extends('layouts.app')

@section('title', 'Visualizar Questão(s)')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg sm:rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2 print-up">Questões</h2>
            @foreach($questoes as $questao)
                    @if($questao->gemini_response)
                        @php
                            $formattedResponse = preg_replace('/\*\*(.*?)\*\*/', '<br><strong>$1</strong><br>', $questao->gemini_response);
                        @endphp
                        <p class="text-gray-600">{!! $formattedResponse !!}</p>
                    @else
                        <p class="text-gray-700"><strong>Questão:</strong> <span class="text-red-500">Não disponível.</span></p>
                    @endif
            @endforeach

            <div class="mt-8 border-t pt-6 flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-4 print-hide justify-center sm:justify-start">
                <a href="{{ route('questoes.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Gerar Nova Questão
                </button>
                <button onclick="copyToClipboard()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Copiar Questão
                </button>
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    Imprimir Questão
                </button>
            </div>

        </div>
    </div>
</div>

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
</script>
@include('layouts.print')
@endsection
