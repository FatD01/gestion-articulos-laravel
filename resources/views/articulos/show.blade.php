@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
    <h2 class="text-2xl font-bold mb-4">Detalle de Artículo</h2>

    <div class="mb-4 text-center">
        @if($articulo->imagen)
            <img src="{{ asset($articulo->imagen) }}" alt="{{ $articulo->titulo }}" class="w-64 h-64 object-cover mx-auto rounded-lg shadow-lg">
        @else
            <img src="{{ asset('images/placeholder.png') }}" alt="Sin imagen" class="w-64 h-64 object-cover mx-auto rounded-lg shadow-lg">
        @endif
    </div>

    <div class="mb-4">
        <strong class="block text-gray-700">ID:</strong>
        <p class="text-gray-900">{{ $articulo->id }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700">Título:</strong>
        <p class="text-gray-900">{{ $articulo->titulo }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700">Descripción:</strong>
        <p class="text-gray-900">{{ $articulo->descripcion }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700">Categoría:</strong>
        <p class="text-gray-900">{{ $articulo->categoria->nombre ?? 'N/A' }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700">Fecha de Creación:</strong>
        <p class="text-gray-900">{{ $articulo->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700">Última Actualización:</strong>
        <p class="text-gray-900">{{ $articulo->updated_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="flex items-center justify-start mt-6">
        <a href="{{ route('articulos.edit', $articulo->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">Editar</a>
        <form action="{{ route('articulos.destroy', $articulo->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('¿Estás seguro de eliminar este artículo?')">Eliminar</button>
        </form>
        <a href="{{ route('articulos.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-auto">Volver al Listado</a>
    </div>
</div>
@endsection