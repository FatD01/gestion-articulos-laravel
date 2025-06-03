@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Listado de Categorías</h2>

    <div class="mb-4">
        <a href="{{ route('categorias.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Crear Nueva Categoría
        </a>
    </div>

    @if($categorias->isEmpty())
    <p class="text-gray-600">No hay categorías registradas.</p>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left text-gray-600 font-semibold">ID</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600 font-semibold">Nombre</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600 font-semibold">Descripción</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600 font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $categoria)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $categoria->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $categoria->nombre }}</td>
                    <td class="py-2 px-4 border-b">{{ Str::limit($categoria->descripcion, 50) }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('categorias.show', $categoria->id) }}"
                            class="text-gray-800 hover:text-gray-900 p-1 rounded-md cursor-pointer inline-flex items-center justify-center"> {{-- Color negro --}}
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                        <a href="{{ route('categorias.edit', $categoria->id) }}"
                            class="text-yellow-600 hover:text-yellow-800 p-1 rounded-md cursor-pointer inline-flex items-center justify-center"> {{-- Color amarillo --}}
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                            </svg>
                        </a>
                        <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 p-1 rounded-md" onclick="return confirm('¿Estás seguro de eliminar esta categoria?')">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection