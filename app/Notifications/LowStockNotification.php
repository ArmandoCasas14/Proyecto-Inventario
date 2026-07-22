<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    // Guardar la notificación en la base de datos
    public function via($notifiable): array
    {
        return ['database'];
    }

    // Estructura de los datos que se guardarán en JSON en la DB
    public function toArray($notifiable): array
    {
        $mensaje = $this->product->current_stock == 0 
            ? "¡ALERTA CRÍTICA! El producto '{$this->product->name}' se ha agotado."
            : "Atención: El producto '{$this->product->name}' tiene stock bajo ({$this->product->current_stock} unidades disponibles).";

        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'current_stock' => $this->product->current_stock,
            'message' => $mensaje,
            'type' => $this->product->current_stock == 0 ? 'danger' : 'warning',
        ];
    }
}