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
}
