<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Invoice extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'customer_name', 
        'total', 
        'payment_type'
    ];
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function scopeByInvoiceNumber(Builder $query, ?string $number): Builder
    {
        if (!empty($number)) {
            // Limpiamos posibles caracteres como '#' que ponga el usuario
            $cleanNumber = ltrim($number, '#');
            return $query->where('id', $cleanNumber);
        }

        return $query;
    }

    /**
     * Scope para filtrar por nombre del cliente
     */
    public function scopeByCustomer(Builder $query, ?string $customer): Builder
    {
        if (!empty($customer)) {
            return $query->where('customer_name', 'LIKE', '%' . $customer . '%');
        }

        return $query;
    }

    /**
     * Scope para filtrar por fecha exacta de creación
     */
    public function scopeByDate(Builder $query, ?string $date): Builder
    {
        if (!empty($date)) {
            // Usamos whereDate para ignorar la parte de la hora (H:i:s) en la BD
            return $query->whereDate('created_at', $date);
        }

        return $query;
    }
}
