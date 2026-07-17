<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'code',
        'name',
        'description',
        'category_id',
        'supplier_id',
        'purchase_price',
        'selling_price',
        'current_stock',
        'minimum_stock',
        'status',
    ];
    // Relación con Categoria (ahora Category)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación con Proveedor (ahora Supplier)
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Relación con Movimientos (ahora Movements)
    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (!$term) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('code', 'like', "%{$term}%"); // Asumiendo que usas 'code'
        });
    }

    /**
     * Filtro por Categoría
     */
    public function scopeOfCategory(Builder $query, ?int $categoryId): Builder
    {
        if (!$categoryId) return $query;

        return $query->where('category_id', $categoryId);
    }

    /**
     * Filtro por Estado de Stock (Disponibles vs Agotados)
     */
    public function scopeStockStatus(Builder $query, ?string $stockstatus): Builder
    {
        if (!$stockstatus) return $query;

        if ($stockstatus === 'disponible') {
            return $query->where('current_stock', '>', 0);
        }

        if ($stockstatus === 'agotado') {
            return $query->where('current_stock', '<=', 0);
        }

        return $query;
    }

    public function scopeOfStatus(Builder $query, ?string $status): Builder
    {
        if ($status === null || $status === '') return $query;

        return $query->where('status', (int)$status);
    }
}
