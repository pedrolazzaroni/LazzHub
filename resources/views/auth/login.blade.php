@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="flex flex-col items-center justify-center opacity-0 transform translate-y-4 transition-all duration-500" style="transition-delay: 100ms">
    <div class="max-w-md w-full space-y-8 p-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-indigo-600 mb-2">LazzHub</h1>
            <h2 class="text-2xl font-semibold text-gray-900">Entre na sua conta</h2>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-8 space-y-6">
            <form class="space-y-4" action="{{ route('login') }}" method="POST">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Entrar
                </button>
            </form>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Não tem uma conta?
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Registre-se
                    </a>
                </p>
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
});
</script>
@endpush
@endsection
