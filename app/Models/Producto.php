<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'categoria_id',
        'proveedor_id',
        'precio_compra',
        'precio_venta',
        'stock_actual',
        'stock_minimo',
        'estado',
    ];
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación con Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
}
