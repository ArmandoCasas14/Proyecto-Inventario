<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class MovementType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
    ];
    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
