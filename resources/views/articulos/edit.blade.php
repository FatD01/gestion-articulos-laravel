@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto border border-gray-200">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Editar Artículo: {{ $articulo->titulo }}</h2>

    <form action="{{ route('articulos.update', $articulo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
            <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $articulo->titulo) }}" 
                   class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm" required>
        </div>
        <div class="mb-4">
            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="5" 
                      class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm" required>{{ old('descripcion', $articulo->descripcion) }}</textarea>
        </div>
        <div class="mb-4">
            <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen Actual</label>
            @if($articulo->imagen)
                <div class="relative">
                    <img src="{{ asset('storage/' . $articulo->imagen) }}" alt="{{ $articulo->titulo }}" 
                         class="w-32 h-32 object-cover rounded-md mb-2 border border-gray-300">
                  
                </div>
            @else
                <p class="text-gray-500 mb-2">No hay imagen actual.</p>
            @endif

            <label for="nueva_imagen" class="block text-sm font-medium text-gray-700 mt-4">Subir Nueva Imagen (Opcional)</label>
            <input type="file" name="imagen" id="nueva_imagen" 
                   class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-pink-500 focus:border-pink-500">
            <p class="mt-1 text-sm text-gray-500">JPG, PNG, GIF, SVG (MAX. 2MB)</p>
        </div>
        <div class="mb-4">
            <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría</label>
            <select name="categoria_id" id="categoria_id" 
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm" required>
                <option value="">Seleccione una categoría</option>
                @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}" {{ old('categoria_id', $articulo->categoria_id) == $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('articulos.index') }}" 
               class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection