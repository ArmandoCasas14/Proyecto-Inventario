<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios'; //

    protected $fillable = [
        'nombre',
        'email', 
        'contraseña', 
        'rol_id', 
        'estado', 
    ];

    protected $hidden = [
        'contraseña', //
        'remember_token',
    ];

    /**
     * Mapea de forma interna la columna 'contraseña' como si fuera 'password' para Laravel.
     */
    public function getAuthPassword()
    {
        return $this->contraseña;
    }
    public function getAuthName()
    {
        return $this->nombre;
    }

    /**
     * Truco definitivo: Cuando Laravel busque internamente $user->password, 
     * devolverá el valor de la columna 'contraseña'.
     */
    public function getPasswordAttribute()
    {
        return $this->contraseña;
    }

    public function getNameAttribute()
    {
        return $this->nombre;
    }

    /**
     * Cuando Laravel intente guardar o actualizar $user->password,
     * lo guardará automáticamente en la columna 'contraseña'.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['contraseña'] = $value;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['nombre'] = $value;
    }


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'usuario_id');
    }
}