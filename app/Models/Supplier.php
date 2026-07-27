<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'legal_name',
        'nit',
        'phone',
        'email',
        'address',
        'status',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (!$term) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('legal_name', 'like', "%{$term}%")
              ->orWhere('nit', 'like', "%{$term}%");
        });
    }

    /**
     * Filtro por Estado (Activos / Inactivos)
     */
    public function scopeOfStatus(Builder $query, ?string $status): Builder
    {
        // Si viene explícitamente 'todos', no aplicamos ningún filtro de estado
        if ($status === 'todos') {
            return $query;
        }

        // Si el valor es null o una cadena vacía '', establecemos '1' por defecto
        $statusValue = ($status === null || $status === '') ? '1' : $status;

        return $query->where('status', (int) $statusValue);
    }
}
