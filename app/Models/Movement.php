<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Movement extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'product_id',
        'movement_type_id',
        'user_id',
        'quantity',
        'unit_price',
        'observation',
    ];
    // Relación con el Producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relación con el Tipo de Movimiento
    public function movementType()
    {
        return $this->belongsTo(MovementType::class);
    }

    // Relación con el Usuario que hizo el movimiento
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
