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
        Schema::create('detalleVentas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_productos')->constrained('productos');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('descuentos', 10,2);
            $table->decimal('total'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalleVentas');
    }
};
