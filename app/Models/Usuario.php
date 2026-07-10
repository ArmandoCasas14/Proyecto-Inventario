<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';
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
