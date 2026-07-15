<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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
    /*public function getAuthPassword()
    {
        return $this->contraseña;
    }
    public function getAuthName()
    {
        return $this->nombre;
    }
    public function getPasswordAttribute()
    {
        return $this->contraseña;
    }

    public function getNameAttribute()
    {
        return $this->nombre;
    }
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $value;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
    }
    */

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
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
    
}