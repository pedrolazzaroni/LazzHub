@extends('layouts.app')

@section('title', 'Resumo - ' . $resumo->materia)

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <!-- Cabeçalho do Resumo -->
            <div class="border-b border-gray-200 bg-indigo-50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $resumo->materia }}</h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Conteúdo: {{ $resumo->conteudo }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Nível: {{ ucfirst($resumo->nivel) }}
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <button onclick="printResume()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Imprimir
                        </button>
                        <button onclick="copyToClipboard()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                            </svg>
                            Copiar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Conteúdo do Resumo -->
            <div class="p-6 bg-white" id="resumeContent">
                <div class="prose max-w-none leading-relaxed space-y-4">
                    @foreach(explode("\n", $resumo->content) as $line)
                        @if(preg_match('/^\d+\./', $line))
                            <h3 class="font-bold text-lg text-indigo-700 mt-6">{{ $line }}</h3>
                        @else
                            <p class="ml-4 text-gray-700">{{ trim($line) }}</p>
                        @endif
                    @endforeach
                </div>

                <!-- Botão Salvar Resumo -->
                <div class="mt-8 border-t pt-6">
                    <button onclick="showSaveModal()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Salvar Resumo
                    </button>
                </div>

                <!-- Modal Salvar Resumo -->
                <div id="saveModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity hidden z-50">
                    <div class="fixed inset-0 overflow-y-auto">
                        <div class="flex min-h-full items-center justify-center p-4">
                            <div class="relative bg-white rounded-lg p-8 max-w-md w-full">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Salvar Resumo</h3>
                                <form id="saveForm" class="space-y-4">
                                    <div>
                                        <label for="titulo" class="block text-sm font-medium text-gray-700">Nome do Resumo</label>
                                        <input type="text" name="titulo" id="titulo" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div class="flex justify-end space-x-3">
                                        <button type="button" onclick="hideSaveModal()"
                                            class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50">
                                            Cancelar
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                            Salvar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rodapé com Ações -->
            <div class="border-t border-gray-200 px-6 py-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">
                        Gerado em {{ $resumo->created_at->format('d/m/Y H:i') }}
                    </span>
                    <a href="{{ route('resumo.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Criar Novo Resumo
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function printResume() {
        const printContents = document.getElementById('resumeContent').innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = `
            <div class="print-header" style="margin-bottom: 20px;">
                <h1 style="font-size: 24px; font-weight: bold;">${@json($resumo->materia)}</h1>
                <p style="margin-top: 5px;">Conteúdo: ${@json($resumo->conteudo)}</p>
                <p>Nível: ${@json(ucfirst($resumo->nivel))}</p>
            </div>
            <div class="print-content">
                ${printContents}
            </div>
        `;

        window.print();
        document.body.innerHTML = originalContents;
    }

    function copyToClipboard() {
        const content = document.getElementById('resumeContent').innerText;
        navigator.clipboard.writeText(content).then(() => {
            // Feedback visual
            const copyButton = document.querySelector('button:contains("Copiar")');
            const originalText = copyButton.innerHTML;
            copyButton.innerHTML = `
                <svg class="h-5 w-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Copiado!
            `;
            setTimeout(() => {
                copyButton.innerHTML = originalText;
            }, 2000);
        }).catch(err => {
            console.error('Erro ao copiar texto: ', err);
            alert('Não foi possível copiar o texto. Por favor, tente novamente.');
        });
    }

    // Adiciona animação de entrada
    document.addEventListener('DOMContentLoaded', function() {
        const content = document.getElementById('resumeContent');
        content.style.opacity = '0';
        content.style.transform = 'translateY(20px)';
        content.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';

        setTimeout(() => {
            content.style.opacity = '1';
            content.style.transform = 'translateY(0)';
        }, 100);
    });

    function showSaveModal() {
        document.getElementById('saveModal').classList.remove('hidden');
    }

    function hideSaveModal() {
        document.getElementById('saveModal').classList.add('hidden');
    }

    document.getElementById('saveForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        try {
            const response = await fetch('/api/resumo/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    resumo_id: {{ $resumo->id }},
                    titulo: document.getElementById('titulo').value
                })
            });

            if (!response.ok) throw new Error('Erro ao salvar resumo');

            hideSaveModal();
            showNotification('Resumo salvo com sucesso! 🎉');
        } catch (error) {
            showNotification('Erro ao salvar o resumo. Tente novamente.', 'error');
        }
    });
</script>
@endpush
@endsection
