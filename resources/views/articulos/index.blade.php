@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Gestión de Artículos</h1>
                <p class="text-blue-100">Administra todos tus artículos desde aquí</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('articulos.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white text-blue-600 font-semibold rounded-lg shadow hover:bg-gray-50 transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Crear Nuevo Artículo
                </a>
            </div>
        </div>
    </div>

    @if($articulos->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100 mb-4">
                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay artículos registrados</h3>
            <p class="text-gray-500 mb-6">Comienza creando tu primer artículo</p>
            <a href="{{ route('articulos.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Crear Artículo
            </a>
        </div>
    @else
        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($articulos as $articulo)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <!-- Image Section -->
                    <div class="relative h-48 bg-gray-100">
                        @if($articulo->imagen)
                            <img src="{{ asset('storage/' . $articulo->imagen) }}" 
                                 alt="{{ $articulo->titulo }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <!-- Category Badge -->
                        @if($articulo->categoria)
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $articulo->categoria->nombre }}
                                </span>
                            </div>
                        @endif
                        <!-- ID Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-800 text-white">
                                #{{ $articulo->id }}
                            </span>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                            {{ $articulo->titulo }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ Str::limit($articulo->descripcion, 120) }}
                        </p>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <div class="flex space-x-2">
                                <!-- View Button -->
                                <a href="{{ route('articulos.show', $articulo->id) }}" 
                                   class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                   title="Ver detalles">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('articulos.edit', $articulo->id) }}" 
                                   class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors duration-200"
                                   title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                            </div>

                            <!-- Delete Button -->
                            <form action="{{ route('articulos.destroy', $articulo->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                        onclick="return confirm('¿Estás seguro de eliminar este artículo?')"
                                        title="Eliminar">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0110 2h4a2 2 0 012 2v2h3a1 1 0 110 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V8a1 1 0 010-2h3V4a2 2 0 01.586-1.414zM10 6h4V4h-4v2zm1 4a1 1 0 10-2 0v8a1 1 0 102 0v-8zm4 0a1 1 0 10-2 0v8a1 1 0 102 0v-8z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($articulos->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    {{ $articulos->links() }}
                </div>
            </div>
        @endif
    @endif
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection