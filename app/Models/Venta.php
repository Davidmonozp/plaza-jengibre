<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['id_detalleVenta', 'id_user', 'fecha'];

    public function  detalleVenta()
    {
        return $this->belongsTo(DetalleVenta::class, 'id
        _detalleVenta');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
