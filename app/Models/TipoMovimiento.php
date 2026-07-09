<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    protected $fillable = [
        'nombre',
        'naturaleza',
    ];
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
}
