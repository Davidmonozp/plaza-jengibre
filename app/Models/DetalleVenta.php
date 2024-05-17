<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $fillable = ['id_productos', 'subtotal', 'descuentos', 'total'];

    public function  producto()
    {
        return $this->belongsTo(Producto::class, 'id
        _producto');
    }
}
