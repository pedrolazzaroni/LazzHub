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
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Faça sua Pergunta</h2>

                <form id="perguntaForm" action="{{ route('pergunta.ask') }}" method="POST">
                    @csrf
                    <div>
                        <label for="pergunta" class="block text-sm font-medium text-gray-700">Digite sua pergunta:</label>
                        <input type="text" name="pergunta" id="pergunta" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="mt-4">
                        <label for="estilo" class="block text-sm font-medium text-gray-700">Escolha um estilo:</label>
                        <select name="estilo" id="estilo" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="formal">Formal</option>
                            <option value="informal">Informal</option>
                            <option value="técnico">Técnico</option>
                            <option value="criativo">Criativo</option>
                        </select>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
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
    function showLoadingModal() {
        const modal = document.getElementById('loadingModal');
        modal.classList.remove('hidden');
    }

    function hideLoadingModal() {
        const modal = document.getElementById('loadingModal');
        modal.classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('perguntaForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const button = this.querySelector('button[type="submit"]');
            button.classList.add('opacity-75', 'cursor-not-allowed');
            button.disabled = true;

            showLoadingModal();

            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao gerar a resposta');
                }
                return response.json();
            })
            .then(data => {
                window.location.href = '/pergunta/resultado/' + data.id;
            })
            .catch(error => {
                alert(`Erro: ${error.message}`);
            })
            .finally(() => {
                hideLoadingModal();
                button.classList.remove('opacity-75', 'cursor-not-allowed');
                button.disabled = false;
            });
        });
    });
</script>
@endpush
@endsection
