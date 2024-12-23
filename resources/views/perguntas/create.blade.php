@extends('layouts.app')

@section('title', 'Fazer Pergunta')

@section('content')
<div class="py-12">
    <!-- Modal de Carregamento -->
    <div id="loadingModal" class="fixed inset-0 bg-gray-300 bg-opacity-75 transition-opacity hidden z-50">
        <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative bg-white p-8 rounded-lg shadow-xl transform transition-all">
                    <div class="text-center">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-600 mb-4"></div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-2">Gerando sua resposta...</h3>
                        <p class="text-sm text-gray-600" id="loadingText">Analisando a pergunta...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg sm:rounded-lg">
            <div class="p-6 bg-gray-100 border-b border-gray-300">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 opacity-0 transform translate-y-4 transition-all duration-500" id="title">
                    Faça sua Pergunta
                </h2>

                <form id="perguntaForm" action="{{ route('pergunta.ask') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 200ms">
                        <label for="pergunta" class="block text-sm font-medium text-gray-800">Digite sua pergunta:</label>
                        <input type="text" name="pergunta" id="pergunta" required maxlength="100"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-sm text-gray-600">
                            <span id="perguntaCount">0</span>/100 caracteres
                        </p>
                    </div>

                    <div class="opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 300ms">
                        <label for="estilo" class="block text-sm font-medium text-gray-800">Escolha um estilo:</label>
                        <select name="estilo" id="estilo" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecione um estilo</option>
                            <option value="formal">Formal</option>
                            <option value="informal">Informal</option>
                            <option value="técnico">Técnico</option>
                            <option value="criativo">Criativo</option>
                        </select>
                    </div>

                    <div class="flex justify-end opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 500ms">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white transition-all duration-300 hover:bg-indigo-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Gerar Resposta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animação de entrada dos elementos
        setTimeout(() => {
            document.querySelectorAll('.opacity-0').forEach(el => {
                el.classList.remove('opacity-0', 'translate-y-4');
            });
        }, 100);

        // Contador de caracteres para pergunta
        const perguntaInput = document.getElementById('pergunta');
        const perguntaCount = document.getElementById('perguntaCount');

        perguntaInput.addEventListener('input', function() {
            perguntaCount.textContent = this.value.length;

            if (this.value.length >= 90) {
                perguntaCount.classList.add('text-red-500');
            } else {
                perguntaCount.classList.remove('text-red-500');
            }
        });


        const loadingTexts = [
            "Analisando a pergunta...",
            "Organizando a resposta...",
            "Gerando conteúdo personalizado...",
            "Ajustando o estilo da resposta...",
            "Finalizando sua resposta..."
        ];

        let currentTextIndex = 0;
        let loadingInterval;

        function showLoadingModal() {
            const modal = document.getElementById('loadingModal');
            const loadingText = document.getElementById('loadingText');
            modal.classList.remove('hidden');

            // Atualiza o texto de carregamento a cada 2 segundos
            loadingInterval = setInterval(() => {
                currentTextIndex = (currentTextIndex + 1) % loadingTexts.length;
                loadingText.textContent = loadingTexts[currentTextIndex];
            }, 2000);
        }

        function hideLoadingModal() {
            const modal = document.getElementById('loadingModal');
            modal.classList.add('hidden');
            clearInterval(loadingInterval);
        }

        // Efeito de envio do formulário
        const form = document.getElementById('perguntaForm');
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Adiciona classe de loading ao botão
            const button = this.querySelector('button[type="submit"]');
            button.classList.add('opacity-75', 'cursor-not-allowed');
            button.disabled = true;

            try {
                showLoadingModal();

                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error || 'Erro ao gerar a resposta');
                }

                const data = await response.json();
                window.location.href = `/pergunta/resultado/${data.id}`;
            } catch (error) {
                hideLoadingModal();
                alert(`Erro: ${error.message}`);
                button.classList.remove('opacity-75', 'cursor-not-allowed');
                button.disabled = false;
            }
        });
    });
</script>
@endpush
@endsection
