<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id('idDetalleVentas');
            $table->integer('cantidadDetalleVentas');
            $table->decimal('precioDetalleVentas', 10, 2);
            $table->decimal('descuentoDetalleVentas', 10, 2);
            $table->decimal('subtotalDetalleVentas', 10, 2);
            $table->unsignedBigInteger('ventaid');
            $table->foreign('ventaid')->references('idVentas')->on('ventas')->onDelete('cascade');
            $table->unsignedBigInteger('productoid');
            $table->foreign('productoid')->references('idProductos')->on('productos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ventas');
    }
};
