@extends('layouts.app')

@section('title', 'Criar Questão')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg sm:rounded-lg">
            <div class="p-6 bg-gray-100 border-b border-gray-300">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 opacity-0 transform translate-y-4 transition-all duration-500" id="title">
                    Criar Questão de Prova
                </h2>

                <form action="{{ route('questoes.store') }}" method="POST" class="space-y-6" id="questaoForm">
                    @csrf

                    <div class="opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 200ms">
                        <label for="conteudo" class="block text-sm font-medium text-gray-800">Conteúdo da Questão</label>
                        <textarea name="conteudo" id="conteudo" rows="4" required maxlength="1000"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Digite o conteúdo da questão..."></textarea>
                        <p class="mt-1 text-sm text-gray-600">
                            <span id="conteudoCount">0</span>/1000 caracteres
                        </p>
                    </div>

                    <div class="opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 300ms">
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

                    <div class="flex justify-end opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 500ms">
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
    document.addEventListener('DOMContentLoaded', function() {
        // Animação de entrada dos elementos
        setTimeout(() => {
            document.querySelectorAll('.opacity-0').forEach(el => {
                el.classList.remove('opacity-0', 'translate-y-4');
            });
        }, 100);

        // Contador de caracteres para conteúdo
        const conteudoInput = document.getElementById('conteudo');
        const conteudoCount = document.getElementById('conteudoCount');

        conteudoInput.addEventListener('input', function() {
            conteudoCount.textContent = this.value.length;

            if (this.value.length >= 900) {
                conteudoCount.classList.add('text-red-500');
            } else {
                conteudoCount.classList.remove('text-red-500');
            }
        });
    });
</script>
@endpush
@endsection
