<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'name', //
        'email', //
        'password', //
        'role_id', //
        'status', //
    ];

    protected $hidden = [
        'password', //
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
        $this->attributes['password'] = $value;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
    }


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    // Relación con el Rol
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relación con los Movimientos
    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
    
}