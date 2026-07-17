<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

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

    public function scopeOfProduct(Builder $query, ?string $term): Builder
    {
        if (!$term) return $query;

        return $query->whereHas('product', function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('code', 'like', "%{$term}%");
        });
    }

    /**
     * Filtro por Tipo de Operación de Movimiento (Suma / Resta) a través del ID del tipo
     */
    public function scopeOfType(Builder $query, ?int $movementTypeId): Builder
    {
        if (!$movementTypeId) return $query;

        return $query->where('movement_type_id', $movementTypeId);
    }

    /**
     * Filtro por Fecha del Evento
     */
    public function scopeOfDate(Builder $query, ?string $date): Builder
    {
        if (!$date) return $query;

        return $query->whereDate('created_at', $date);
    }

    /**
     * Filtro por Encargado / Usuario Responsable (Búsqueda por Nombre)
     */
    public function scopeOfUser(Builder $query, ?string $userName): Builder
    {
        if (!$userName) return $query;

        return $query->whereHas('user', function ($q) use ($userName) {
            $q->where('name', 'like', "%{$userName}%");
        });
    }
}
