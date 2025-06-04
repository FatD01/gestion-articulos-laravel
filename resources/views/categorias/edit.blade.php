@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r  from-gray-900 to-pink-900 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Editar Categoría</h1>
                <p class="text-green-100">Actualiza los detalles de esta categoría</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('categorias.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white text-blue-600 font-semibold rounded-lg shadow hover:bg-gray-50 transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver a Categorías
                </a>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-2xl mx-auto">
        <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Form Content -->
            <div class="p-6 sm:p-8">
                <div class="space-y-6">
                    <!-- Name Field -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la categoría</label>
                        <input type="text" name="nombre" id="nombre" 
                               value="{{ old('nombre', $categoria->nombre) }}"
                               class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-900 focus:border-green-500 transition duration-200"
                               placeholder="Ej: Tecnología" required>
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description Field -->
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="4"
                                  class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                                  placeholder="Breve descripción de la categoría">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                        @error('descripcion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Color Field (optional) -->
                    <!-- <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color identificador</label>
                        <div class="flex space-x-2">
                            @foreach(['green', 'blue', 'purple', 'red', 'yellow', 'indigo'] as $color)
                            <div class="flex items-center">
                                <input type="radio" name="color" id="color-{{ $color }}" value="{{ $color }}"
                                       class="hidden peer" {{ old('color', $categoria->color ?? 'green') == $color ? 'checked' : '' }}>
                                <label for="color-{{ $color }}" 
                                       class="w-8 h-8 rounded-full bg-{{ $color }}-500 cursor-pointer border-2 border-transparent peer-checked:border-gray-800 hover:opacity-90 transition duration-200"></label>
                            </div>
                            @endforeach
                        </div>
                    </div> -->
                </div>
            </div>
            
            <!-- Form Footer -->
            <div class="bg-gray-50 px-6 py-4 sm:px-8 flex justify-end space-x-3">
                <a href="{{ route('categorias.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-yellow-900 hover:bg-pink-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Actualizar Categoría
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    input[type="radio"]:checked + label {
        box-shadow: 0 0 0 2px #1f2937;
    }
</style>
@endpush
@endsection