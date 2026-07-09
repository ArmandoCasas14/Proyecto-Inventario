<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'nombre',
        'contraseña',
        'email',
        'rol_id',
        'estado',
    ];
    protected $hidden = [
        'contraseña',
    ];
    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
}
