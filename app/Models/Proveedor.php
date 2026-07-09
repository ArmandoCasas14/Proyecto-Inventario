<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedores';
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
