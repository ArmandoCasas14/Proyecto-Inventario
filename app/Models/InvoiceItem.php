<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class InvoiceItem extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'invoice_id', 
        'product_id', 
        'quantity', 
        'unit_price'
    ];
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // Relación: Este detalle pertenece a un producto (para sacar el nombre, stock, etc.)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
