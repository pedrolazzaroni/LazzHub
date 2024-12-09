@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800">Bem-vindo, {{ Auth::user()->name }}!</h2>
                <p class="mt-4 text-gray-600">
                    Você está logado no sistema.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
