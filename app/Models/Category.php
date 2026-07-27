<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'status',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeSearchByName(Builder $query, ?string $name): Builder
    {
        if (!empty($name)) {
            return $query->where('name', 'LIKE', '%' . $name . '%');
        }

        return $query;
    }

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
