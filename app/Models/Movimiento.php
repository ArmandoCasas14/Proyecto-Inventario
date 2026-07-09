<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movimiento extends Model
{
    use HasFactory;
    protected $table = 'movimientos';
    protected $fillable = [
        'producto_id',
        'tipo_movimiento_id',
        'usuario_id',
        'cantidad',
        'precio_unitario',
        'observacion',
    ];
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Relación con el Tipo de Movimiento
    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class);
    }

    // Relación con el Usuario que hizo el movimiento
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
