@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-purple-900 to-pink-800 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Gestión de Categorías</h1>
                <p class="text-purple-100">Administra todas las categorías de tus artículos</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('categorias.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white text-purple-900 font-semibold rounded-lg shadow hover:bg-gray-50 transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Crear Nueva Categoría
                </a>
            </div>
        </div>
    </div>

    @if($categorias->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-purple-100 mb-4">
                <svg class="h-8 w-8 text-purple-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay categorías registradas</h3>
            <p class="text-gray-500 mb-6">Comienza creando tu primera categoría para organizar tus artículos</p>
            <a href="{{ route('categorias.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Crear Categoría
            </a>
        </div>
    @else
        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($categorias as $categoria)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <!-- Header with gradient -->
                    <div class="bg-gradient-to-r from-gray-900 to-pink-900 p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold text-lg">{{ $categoria->nombre }}</h3>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-white bg-opacity-20 text-black">
                                #{{ $categoria->id }}
                            </span>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-5">
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Descripción:</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                @if($categoria->descripcion)
                                    {{ Str::limit($categoria->descripcion, 120) }}
                                @else
                                    <span class="italic text-gray-400">Sin descripción</span>
                                @endif
                            </p>
                        </div>

                        <!-- Stats Section -->
                        <!-- <div class="bg-gray-50 rounded-lg p-3 mb-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Artículos:</span>
                                <span class="font-semibold text-purple-600">
                                    {{ $categoria->articulos_count ?? 0 }}
                                </span>
                            </div>
                        </div> -->

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <div class="flex space-x-2">
                                <!-- View Button -->
                                <a href="{{ route('categorias.show', $categoria->id) }}" 
                                   class="inline-flex items-center justify-center w-9 h-9 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200 group"
                                   title="Ver detalles">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('categorias.edit', $categoria->id) }}" 
                                   class="inline-flex items-center justify-center w-9 h-9 text-gray-600 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors duration-200 group"
                                   title="Editar">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                            </div>

                            <!-- Delete Button -->
                            <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center justify-center w-9 h-9 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200 group"
                                        onclick="return confirm('¿Estás seguro de eliminar esta categoría?')"
                                        title="Eliminar">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0110 2h4a2 2 0 012 2v2h3a1 1 0 110 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V8a1 1 0 010-2h3V4a2 2 0 01.586-1.414zM10 6h4V4h-4v2zm1 4a1 1 0 10-2 0v8a1 1 0 102 0v-8zm4 0a1 1 0 10-2 0v8a1 1 0 102 0v-8z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Bottom accent -->
                    <div class="h-1 bg-gradient-to-r from-gray-900 to-pink-600"></div>
                </div>
            @endforeach
        </div>

        <!-- Additional Stats Card -->
        <!-- <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Resumen de Categorías
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Categorías</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $categorias->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-4 border border-green-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Con Artículos</p>
                            <p class="text-2xl font-bold text-green-600">
                                {{ $categorias->where('articulos_count', '>', 0)->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-4 border border-purple-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Más Popular</p>
                            <p class="text-lg font-bold text-purple-600 truncate">
                                {{ $categorias->sortByDesc('articulos_count')->first()->nombre ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    @endif
</div>

@push('styles')
<style>
    .hover\:-translate-y-1:hover {
        transform: translateY(-0.25rem);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .grid > div {
        animation: fadeIn 0.5s ease-out forwards;
    }
    
    .grid > div:nth-child(1) { animation-delay: 0.1s; }
    .grid > div:nth-child(2) { animation-delay: 0.2s; }
    .grid > div:nth-child(3) { animation-delay: 0.3s; }
    .grid > div:nth-child(4) { animation-delay: 0.4s; }
    .grid > div:nth-child(5) { animation-delay: 0.5s; }
    .grid > div:nth-child(6) { animation-delay: 0.6s; }
</style>
@endpush
@endsection