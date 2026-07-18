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
        'otp_code', 
        'otp_expires_at'
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
    public function generateOtp(): string
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->otp_code = $otp;
        $this->otp_expires_at = now()->addMinutes(5);
        $this->save();
        return $otp;
    }
    public function verifyOtp(string $code): bool
    {
        if (!$this->otp_code || !$this->otp_expires_at) {
            return false;
        }
        if (now()->gt($this->otp_expires_at)) {
            return false;
        }
        return hash_equals($this->otp_code, $code);
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
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
    
}