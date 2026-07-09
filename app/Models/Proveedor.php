<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $fillable = [
        'razon_social',
        'nit',
        'telefono',
        'email',
        'direccion',
        'estado',
    ];
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
