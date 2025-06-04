<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Categoria; // Importa el modelo Categoria
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Se mantiene por si se usa en otras partes, aunque no para la subida directa
use Illuminate\Support\Str; // Importa esto para usar Str::uuid() para nombres únicos
use Illuminate\Support\Facades\Log; // Importa el facade Log para registrar errores

class ArticulosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Carga los artículos con sus categorías para evitar el problema N+1
        $articulos = Articulo::with('categoria')->latest()->paginate(10);
        return view('articulos.index', compact('articulos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all(); // Obtiene todas las categorías para el select
        return view('articulos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validación de imagen
            'categoria_id' => 'required|exists:categorias,id', // Debe existir en la tabla categorias
        ]);

        $imagePathForDb = null;

        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            // La función store() de la fachada Storage guarda el archivo en el disco especificado.
            // El primer argumento es la carpeta dentro del disco (ej. 'imagenes_articulos' dentro de storage/app/public)
            // El segundo argumento es el 'disco' que quieres usar, en este caso 'public' (definido en config/filesystems.php)
            try {
                $imagePathForDb = Storage::disk('public')->putFile('imagenes_articulos', $image);
                // putFile() ya genera un nombre de archivo único por defecto (hash) y devuelve la ruta relativa al disco.
                // Si necesitas un nombre de archivo específico como tu UUID, usarías putFileAs:
                // $fileName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                // $imagePathForDb = Storage::disk('public')->putFileAs('imagenes_articulos', $image, $fileName);
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Error al subir la imagen a Storage: ' . $e->getMessage());
            }
        }

        $validatedData['imagen'] = $imagePathForDb; // Asigna la ruta guardada o null a los datos validados

        Articulo::create($validatedData);

        return redirect()->route('articulos.index')
            ->with('success', 'Artículo creado exitosamente.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Articulo $articulo)
    {
        // Carga la categoría del artículo
        $articulo->load('categoria');
        return view('articulos.show', compact('articulo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Articulo $articulo)
    {
        $categorias = Categoria::all(); // Obtiene todas las categorías para el select
        return view('articulos.edit', compact('articulo', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Articulo $articulo)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $imagePathForDb = $articulo->imagen; // Mantener la imagen existente por defecto

        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior del disco 'public' de Storage
            // Asegúrate de que la ruta de la imagen en DB sea relativa al disco 'public' (ej. 'imagenes_articulos/nombre.png')
            if ($articulo->imagen) { // Solo si hay una imagen existente
                // Verifica que la imagen no sea tu 'placeholder.png' si lo usas,
                // aunque el `unlink` lo maneja mejor el Storage::delete()
                // La ruta debe ser relativa al disco, no empezar con /
                if (Storage::disk('public')->exists($articulo->imagen)) {
                    try {
                        Storage::disk('public')->delete($articulo->imagen);
                        Log::info('Imagen antigua eliminada: ' . $articulo->imagen);
                    } catch (\Exception $e) {
                        Log::error('Error al eliminar imagen antigua de Storage: ' . $e->getMessage() . ' Ruta: ' . $articulo->imagen);
                    }
                }
            }

            // Subir la nueva imagen al disco 'public' de Storage
            $image = $request->file('imagen');
            try {
                // putFile() genera un nombre de archivo único por defecto (hash) y devuelve la ruta relativa al disco.
                // Esta es la forma preferida y maneja subcarpetas y permisos automáticamente si el disco está configurado.
                $imagePathForDb = Storage::disk('public')->putFile('imagenes_articulos', $image);
                Log::info('Nueva imagen subida: ' . $imagePathForDb);
            } catch (\Exception $e) {
                Log::error('Error al subir la nueva imagen a Storage: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Error al subir la nueva imagen: ' . $e->getMessage());
            }
        }
        // Si no se sube una nueva imagen, $imagePathForDb mantiene la URL de la imagen antigua

        $validatedData['imagen'] = $imagePathForDb; // Asigna la ruta guardada o null a los datos validados

        $articulo->update($validatedData); // Actualiza los datos del artículo

        return redirect()->route('articulos.index')
            ->with('success', 'Artículo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Articulo $articulo)
    {
        // Eliminar la imagen asociada si existe y no es un placeholder
        if ($articulo->imagen && !Str::contains($articulo->imagen, 'placeholder.png')) {
            // Construye la ruta absoluta al archivo en public/
            $imagePath = public_path(ltrim($articulo->imagen, '/'));
            if (file_exists($imagePath)) {
                try {
                    unlink($imagePath); // Elimina el archivo físico
                } catch (\Exception $e) {
                    // Opcional: registrar el error si la eliminación falla
                    Log::error('Error al eliminar imagen del public/ en destroy: ' . $e->getMessage() . ' Ruta: ' . $imagePath);
                }
            }
        }

        $articulo->delete();

        // *** REDIRECCIÓN FALTANTE EN TU CÓDIGO ANTERIOR ***
        return redirect()->route('articulos.index')
            ->with('success', 'Artículo eliminado exitosamente.');
    }
}
