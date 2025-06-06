@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-md mx-auto">
    <h2 class="text-2xl font-bold mb-4">Detalle de Categoría</h2>

    <div class="mb-4">
        <strong class="block text-gray-700">ID:</strong>
        <p class="text-gray-900">{{ $categoria->id }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700">Nombre:</strong>
        <p class="text-gray-900">{{ $categoria->nombre }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700">Descripción:</strong>
        <p class="text-gray-900">{{ $categoria->descripcion ?? 'N/A' }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700">Fecha de Creación:</strong>
        <p class="text-gray-900">{{ $categoria->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700">Última Actualización:</strong>
        <p class="text-gray-900">{{ $categoria->updated_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="flex items-center justify-start mt-6">
        <a href="{{ route('categorias.edit', $categoria->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">Editar</a>
        <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">Eliminar</button>
        </form>
        <a href="{{ route('categorias.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-auto">Volver al Listado</a>
    </div>
</div>
@endsection