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

        $imagePathForDb = null; // Inicializamos la ruta de la imagen a null

        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension; // Genera un nombre de archivo único con UUID

            // Define la ruta absoluta donde se guardará la imagen dentro de public
            $destinationFolder = 'imagenes_articulos'; // Nombre de la carpeta deseada
            $destinationPath = public_path($destinationFolder); // Ruta absoluta completa

            // *** Intenta crear la carpeta si no existe. Esto es crucial. ***
            if (!file_exists($destinationPath)) {
                try {
                    // Crea la carpeta de forma recursiva con permisos 0777 para asegurar escritura en Windows
                    // (Puedes reducir a 0755 en un entorno de producción si es seguro)
                    mkdir($destinationPath, 0777, true);
                } catch (\Exception $e) {
                    // Si falla la creación de la carpeta, redirige con un mensaje de error explícito
                    return redirect()->back()->withInput()->with('error', 'Error al crear la carpeta de imágenes: ' . $e->getMessage() . '. Por favor, verifica los permisos de escritura en el directorio ' . dirname($destinationPath));
                }
            }

            // *** Intenta mover el archivo subido a la carpeta destino. ***
            try {
                $image->move($destinationPath, $fileName);
                // La ruta para guardar en la base de datos es relativa a la carpeta public
                $imagePathForDb = '/' . $destinationFolder . '/' . $fileName; // Ejemplo: /imagenes_articulos/nombre_unico.jpg
            } catch (\Exception $e) {
                // Si falla el movimiento del archivo, redirige con un mensaje de error explícito
                return redirect()->back()->withInput()->with('error', 'Error al subir la imagen: ' . $e->getMessage() . '. Asegúrate de que la carpeta ' . $destinationPath . ' tenga permisos de escritura.');
            }
        }

        $validatedData['imagen'] = $imagePathForDb; // Asigna la ruta pública o null a los datos validados

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
            // Eliminar la imagen anterior si existe y no es el placeholder
            if ($articulo->imagen && !Str::contains($articulo->imagen, 'placeholder.png')) {
                // Asegúrate de que la ruta guardada no empiece con /, public_path() lo maneja bien
                $oldImagePath = public_path(ltrim($articulo->imagen, '/'));
                if (file_exists($oldImagePath)) {
                    try {
                        unlink($oldImagePath); // Eliminar el archivo físico
                    } catch (\Exception $e) {
                        // Opcional: registrar el error si la eliminación falla, pero no detener la ejecución
                        Log::error('Error al eliminar imagen antigua del public/: ' . $e->getMessage() . ' Ruta: ' . $oldImagePath);
                    }
                }
            }

            $image = $request->file('imagen');
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;

            $destinationFolder = 'imagenes_articulos';
            $destinationPath = public_path($destinationFolder);

            // *** Intenta crear la carpeta si no existe. Esto es crucial. ***
            if (!file_exists($destinationPath)) {
                try {
                    mkdir($destinationPath, 0777, true);
                } catch (\Exception $e) {
                    return redirect()->back()->withInput()->with('error', 'Error al crear la carpeta de imágenes: ' . $e->getMessage() . '. Por favor, verifica los permisos de escritura en el directorio ' . dirname($destinationPath));
                }
            }

            // *** Intenta mover el nuevo archivo ***
            try {
                $image->move($destinationPath, $fileName);
                $imagePathForDb = '/' . $destinationFolder . '/' . $fileName;
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Error al subir la nueva imagen: ' . $e->getMessage() . '. Asegúrate de que la carpeta ' . $destinationPath . ' tenga permisos de escritura.');
            }
        }
        // Si no se sube una nueva imagen, $imagePathForDb mantiene la URL de la imagen antigua

        $validatedData['imagen'] = $imagePathForDb;

        $articulo->update($validatedData); // Actualiza los datos del artículo

        // *** REDIRECCIÓN FALTANTE EN TU CÓDIGO ANTERIOR ***
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