@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
<div class="py-12 overflow-hidden">
    <div class="max-w-3xl mx-auto sm:px-4 lg:px-6 opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 100ms">
        <div class="bg-blue-50 overflow-hidden shadow-lg sm:rounded-lg">
            <div class="p-4 bg-indigo-500 border-b border-gray-300 opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 300ms">
                <h2 class="text-2xl font-semibold text-white mb-4 opacity-0 transform translate-y-4 transition-all duration-500">
                    Meu Perfil
                </h2>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="bg-blue-50 shadow-lg p-3 rounded-md opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 500ms">
                        <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-2">
                            Foto de Perfil
                        </label>
                        <div class="flex justify-between items-center">
                            <button type="button" id="chooseImageButton" class="bg-indigo-600 text-white px-3 py-2 rounded-md hover:bg-indigo-700 transition-all duration-300">
                                Escolher Imagem
                            </button>
                            <span id="fileName" class="text-sm text-gray-600 ml-2"></span>
                            <label for="profile_picture" class="cursor-pointer ml-auto">
                                <span class="inline-block h-28 w-28 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center" id="profilePicturePreview">
                                    @if(Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="h-full w-full object-cover">
                                    @else
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 24H0V0h24v24z" fill="none"/>
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    @endif
                                </span>
                            </label>
                        </div>
                        <input type="file" name="profile_picture" id="profile_picture" class="hidden" accept="image/*">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 700ms">
                        <div class="bg-blue-50 shadow-lg p-3 rounded-md">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="bg-blue-50 shadow-lg p-3 rounded-md">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 900ms">
                        <div class="bg-blue-50 shadow-lg p-3 rounded-md">
                            <label for="password" class="block text-sm font-medium text-gray-700">Nova Senha</label>
                            <input type="password" name="password" id="password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="bg-blue-50 shadow-lg p-3 rounded-md">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nova Senha</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="flex justify-end opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 1100ms">
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white transition-all duration-300 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Atualizar Perfil
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
    setTimeout(() => {
        document.querySelectorAll('.opacity-0').forEach(el => {
            el.classList.remove('opacity-0', 'translate-y-4');
        });
    }, 100);

    const profilePictureInput = document.getElementById('profile_picture');
    const profilePicturePreview = document.getElementById('profilePicturePreview');
    const fileName = document.getElementById('fileName');
    const chooseImageButton = document.getElementById('chooseImageButton');

    chooseImageButton.addEventListener('click', function() {
        profilePictureInput.click();
    });

    profilePictureInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePicturePreview.innerHTML = `<img src="${e.target.result}" alt="Profile Picture" class="h-full w-full object-cover">`;
            }
            reader.readAsDataURL(file);
            fileName.textContent = file.name;
        } else {
            fileName.textContent = '';
        }
    });

    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        form.submit();
    });

    @if(session('success'))
        const notification = document.getElementById('notification');
        notification.classList.remove('hidden', 'translate-x-full', 'opacity-0');
        setTimeout(() => {
            notification.classList.add('translate-x-full', 'opacity-0');
        }, 2000);
    @endif
});
</script>
@endpush
@endsection
