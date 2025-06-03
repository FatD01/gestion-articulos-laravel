<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Campos que pueden ser asignados masivamente
    protected $fillable = ['nombre', 'descripcion'];

    /**
     * Get the articulos for the categoria.
     */
    public function articulos()
    {
        return $this->hasMany(Articulo::class);
    }
}