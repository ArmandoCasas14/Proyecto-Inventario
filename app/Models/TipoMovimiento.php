<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TipoMovimiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'naturaleza',
    ];
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
}
