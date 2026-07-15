<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
