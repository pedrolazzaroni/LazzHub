@extends('layouts.app')

@section('title', 'Criar Resumo')

@section('content')
<div class="py-12">
    <!-- Modal de Carregamento -->
    <div id="loadingModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity hidden z-50">
        <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative bg-white p-8 rounded-lg shadow-xl transform transition-all">
                    <div class="text-center">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-600 mb-4"></div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-2">Gerando seu resumo...</h3>
                        <p class="text-sm text-gray-500" id="loadingText">Analisando o conteúdo...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 opacity-0 transform translate-y-4 transition-all duration-500" id="title">
                    Criar Resumo de Prova
                </h2>

                <form action="{{ route('resumo.generate') }}" method="POST" class="space-y-6" id="resumoForm">
                    @csrf

                    <div class="opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 200ms">
                        <label for="materia" class="block text-sm font-medium text-gray-700">Matéria</label>
                        <input type="text" name="materia" id="materia" required
                            maxlength="50"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-sm text-gray-500">
                            <span id="materiaCount">0</span>/50 caracteres
                        </p>
                    </div>

                    <div class="opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 300ms">
                        <label for="curso" class="block text-sm font-medium text-gray-700">Curso</label>
                        <input type="text" name="curso" id="curso" required
                            maxlength="50"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ex: Engenharia, Medicina, História...">
                        <p class="mt-1 text-sm text-gray-500">
                            <span id="cursoCount">0</span>/50 caracteres
                        </p>
                    </div>

                    <div class="opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 400ms">
                        <label for="conteudo" class="block text-sm font-medium text-gray-700">Qual é o conteúdo da prova?</label>
                        <textarea name="conteudo" id="conteudo" rows="5" required maxlength="50"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ex: Revolução Industrial, Segunda Guerra Mundial, Equações do 2º grau..."></textarea>
                        <p class="mt-1 text-sm text-gray-500">
                            <span class="text-gray-600">Digite o tema ou assunto que será cobrado na prova</span>
                            <br>
                            <span id="conteudoCount">0</span>/50 caracteres
                        </p>
                    </div>

                    <div class="opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 600ms">
                        <label for="nivel" class="block text-sm font-medium text-gray-700">Nível de Ensino</label>
                        <select name="nivel" id="nivel" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecione um nível</option>
                            <option value="fundamental1">Fundamental 1</option>
                            <option value="fundamental2">Fundamental 2</option>
                            <option value="medio">Ensino Médio</option>
                            <option value="universitario">Universitário</option>
                        </select>
                    </div>

                    <div class="flex justify-end opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 800ms">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white transition-all duration-300 hover:bg-indigo-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Gerar Resumo
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

        // Contador de caracteres para matéria
        const materiaInput = document.getElementById('materia');
        const materiaCount = document.getElementById('materiaCount');

        materiaInput.addEventListener('input', function() {
            materiaCount.textContent = this.value.length;

            if (this.value.length >= 45) {
                materiaCount.classList.add('text-red-500');
            } else {
                materiaCount.classList.remove('text-red-500');
            }
        });

        // Contador de caracteres para curso
        const cursoInput = document.getElementById('curso');
        const cursoCount = document.getElementById('cursoCount');

        cursoInput.addEventListener('input', function() {
            cursoCount.textContent = this.value.length;

            if (this.value.length >= 45) {
                cursoCount.classList.add('text-red-500');
            } else {
                cursoCount.classList.remove('text-red-500');
            }
        });

        // Contador de caracteres para conteúdo
        const conteudoInput = document.getElementById('conteudo');
        const conteudoCount = document.getElementById('conteudoCount');

        conteudoInput.addEventListener('input', function() {
            conteudoCount.textContent = this.value.length;

            if (this.value.length >= 45) {
                conteudoCount.classList.add('text-red-500');
            } else {
                conteudoCount.classList.remove('text-red-500');
            }
        });

        // Efeito de hover suave no select
        const nivelSelect = document.getElementById('nivel');
        nivelSelect.addEventListener('change', function() {
            this.classList.add('scale-105');
            setTimeout(() => this.classList.remove('scale-105'), 200);
        });

        const loadingTexts = [
            "Analisando o conteúdo...",
            "Organizando as informações...",
            "Criando um resumo personalizado...",
            "Ajustando o nível de complexidade...",
            "Finalizando seu resumo..."
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

        async function generatePrompt(materia, conteudo, nivel, curso) {
            const nivelTexto = {
                'fundamental1': 'Ensino Fundamental I',
                'fundamental2': 'Ensino Fundamental II',
                'medio': 'Ensino Médio',
                'universitario': 'Ensino Universitário'
            }[nivel];

            return `Crie um resumo educacional sobre ${conteudo} da matéria ${materia} para um aluno do ${nivelTexto}.
                    O resumo é para o curso de ${curso}.
                    O resumo deve ser:
                    1. Adequado ao nível de ensino especificado
                    2. Claro e objetivo
                    3. Focado nos pontos mais importantes
                    4. Organizado em tópicos
                    5. Incluir exemplos quando apropriado

                    Por favor, estruture o resumo de forma que facilite o estudo e a memorização.`;
        }

        async function callGeminiAPI(prompt) {
            try {
                console.log('Enviando prompt:', prompt);
                const response = await fetch('/api/generate-resume', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        prompt,
                        materia: document.getElementById('materia').value,
                        curso: document.getElementById('curso').value,
                        nivel: document.getElementById('nivel').value,
                        conteudo: document.getElementById('conteudo').value
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    console.error('Erro da API:', errorData);
                    throw new Error(errorData.error || 'Erro ao gerar o resumo');
                }

                return await response.json();
            } catch (error) {
                console.error('Erro detalhado:', error);
                throw error;
            }
        }

        // Efeito de envio do formulário
        const form = document.getElementById('resumoForm');
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Adiciona classe de loading ao botão
            const button = this.querySelector('button[type="submit"]');
            button.classList.add('opacity-75', 'cursor-not-allowed');
            button.disabled = true;

            try {
                const materia = document.getElementById('materia').value;
                const conteudo = document.getElementById('conteudo').value;
                const nivel = document.getElementById('nivel').value;
                const curso = document.getElementById('curso').value;

                console.log('Dados do formulário:', { materia, conteudo, nivel, curso });

                showLoadingModal();

                const prompt = await generatePrompt(materia, conteudo, nivel, curso);
                console.log('Prompt gerado:', prompt);
                const response = await callGeminiAPI(prompt);

                window.location.href = `/resumo/resultado/${response.id}`;
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
