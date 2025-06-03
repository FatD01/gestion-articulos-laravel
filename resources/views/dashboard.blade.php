@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto text-center">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Bienvenido a tu Gestor de Contenido</h1>
    <p class="text-lg text-gray-600 mb-8">Administra tus artículos y categorías de forma sencilla.</p>

    <div class="flex flex-col md:flex-row justify-center items-center gap-6">
        <a href="{{ route('articulos.index') }}" class="w-full md:w-auto bg-pink-700 hover:bg-pink-800 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
            <div class="flex items-center justify-center">
                <svg class="w-7 h-7 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-7.001Z" clip-rule="evenodd"/>
                </svg>
                Gestionar Artículos
            </div>
        </a>

        <a href="{{ route('categorias.index') }}" class="w-full md:w-auto bg-gray-800 hover:bg-gray-900 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
            <div class="flex items-center justify-center">
                <svg class="w-7 h-7 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3.75 3.75a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75Zm0 4.5a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75Zm0 4.5a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75Zm0 4.5a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75Z" clip-rule="evenodd"/>
                </svg>
                Gestionar Categorías
            </div>
        </a>
    </div>
</div>
@endsection