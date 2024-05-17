<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['name', 'descripcion', 'id_categoria', 'precio'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
    
}
