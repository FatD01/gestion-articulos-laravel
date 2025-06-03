<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

    // Campos que pueden ser asignados masivamente
    protected $fillable = ['titulo', 'descripcion', 'imagen', 'categoria_id'];

    /**
     * Get the categoria that owns the articulo.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}