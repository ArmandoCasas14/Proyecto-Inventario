<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos');
            $table->foreignId('tipo_movimiento_id')->constrained('tipo_movimientos');
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->unsignedInteger('cantidad');
            $table->decimal('precio_unitario',10,2);
            $table->text('observacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
