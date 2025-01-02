@extends('layouts.app')

@section('title', 'Criar Questão')

@section('content')
<div class="py-12">
    <!-- Modal de Carregamento -->
    <div id="loadingModal" class="fixed inset-0 bg-gray-300 bg-opacity-75 transition-opacity hidden z-50">
        <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative bg-white p-8 rounded-lg shadow-xl transform transition-all">
                    <div class="text-center">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-600 mb-4"></div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-2">Criando sua questão...</h3>
                        <p class="text-sm text-gray-600" id="loadingText">Analisando o conteúdo...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg sm:rounded-lg">
            <div class="p-6 bg-gray-100 border-b border-gray-300">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                    Criar Questão de Prova
                </h2>

                <form action="{{ route('questoes.store') }}" method="POST" class="space-y-6" id="questaoForm">
                    @csrf

                    <!-- Campos Matéria e Quantidade Lado a Lado -->
                    <div class="flex flex-col md:flex-row md:space-x-6">
                        <!-- Campo Matéria -->
                        <div class="w-full md:w-3/4 mb-4 md:mb-0">
                            <label for="materia" class="block text-sm font-medium text-gray-800">Matéria</label>
                            <input type="text" name="materia" id="materia" required maxlength="255"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Digite a matéria da questão...">
                            <p class="mt-1 text-sm text-gray-600">
                                <span id="materiaCount">0</span>/255 caracteres
                            </p>
                        </div>

                        <!-- Campo Quantidade de Questões -->
                        <div class="w-full md:w-1/4">
                            <label for="quantidade" class="block text-sm font-medium text-gray-800">Quantidade de Questões</label>
                            <select name="quantidade" id="quantidade" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <p class="mt-1 text-sm text-gray-600">
                                Selecione quantas questões deseja criar (máximo 10).
                            </p>
                        </div>
                    </div>

                    <!-- Campo Conteúdo da Questão -->
                    <div class="w-full">
                        <label for="conteudo" class="block text-sm font-medium text-gray-800">Conteúdo da Questão</label>
                        <textarea name="conteudo" id="conteudo" rows="4" required maxlength="1000"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Digite o conteúdo da questão..."></textarea>
                        <p class="mt-1 text-sm text-gray-600">
                            <span id="conteudoCount">0</span>/1000 caracteres
                        </p>
                    </div>

                    <!-- Campo Nível de Dificuldade -->
                    <div class="w-full">
                        <label for="nivel" class="block text-sm font-medium text-gray-800">Nível de Dificuldade</label>
                        <select name="nivel" id="nivel" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecione um nível</option>
                            <option value="Muito Fácil">Muito Fácil</option>
                            <option value="Fácil">Fácil</option>
                            <option value="Médio">Médio</option>
                            <option value="Difícil">Difícil</option>
                            <option value="Muito Difícil">Muito Difícil</option>
                        </select>
                    </div>

                    <!-- Botão de Submissão -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white transition-all duration-300 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Criar Questão
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// filepath: /c:/xampp/htdocs/Laravel/LazzHub/resources/views/questoes/create.blade.php
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente carregado e analisado');

    // Remover classes de ocultação para exibir os elementos
    setTimeout(() => {
        document.querySelectorAll('.opacity-0, .translate-y-4').forEach(el => {
            el.classList.remove('opacity-0', 'translate-y-4');
            console.log('Classes removidas de:', el);
        });
    }, 100);

    // Contador de caracteres para Matéria
    const materiaInput = document.getElementById('materia');
    const materiaCount = document.getElementById('materiaCount');

    materiaInput.addEventListener('input', function() {
        materiaCount.textContent = this.value.length;

        if (this.value.length >= 230) { // Limite ajustado para manter 255 no total
            materiaCount.classList.add('text-red-500');
        } else {
            materiaCount.classList.remove('text-red-500');
        }
    });

    // Contador de caracteres para Conteúdo
    const conteudoInput = document.getElementById('conteudo');
    const conteudoCount = document.getElementById('conteudoCount');

    conteudoInput.addEventListener('input', function() {
        conteudoCount.textContent = this.value.length;

        if (this.value.length >= 900) { // Limite ajustado para manter 1000 no total
            conteudoCount.classList.add('text-red-500');
        } else {
            conteudoCount.classList.remove('text-red-500');
        }
    });

    const loadingTexts = [
        "Analisando o conteúdo...",
        "Organizando as informações...",
        "Criando a questão...",
        "Ajustando o nível de dificuldade...",
        "Finalizando sua questão..."
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
    const form = document.getElementById('questaoForm');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validação adicional no front-end para o campo 'materia'
        if (!materiaInput.value.trim()) {
            alert('Por favor, preencha o campo Matéria.');
            return;
        }

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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Erro ao criar a questão');
            }

            const data = await response.json();
            window.location.href = `/questoes/show/${data.ids.join(',')}`;
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
