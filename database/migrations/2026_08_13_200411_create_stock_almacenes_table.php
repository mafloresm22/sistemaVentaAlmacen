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
        Schema::create('stock_almacenes', function (Blueprint $table) {
            $table->id('idStockAlmacen');
            $table->integer('stockactualAlmacen');
            $table->integer('stockminimoAlmacen');
            $table->enum('estadoStockAlmacen', ['En stock', 'Sin stock', 'Bajo stock', 'Bloqueado'])->default('En stock');
            $table->unsignedBigInteger('productoid');
            $table->foreign('productoid')->references('idProductos')->on('productos')->onDelete('cascade');
            $table->unsignedBigInteger('sucursalid');
            $table->foreign('sucursalid')->references('idSucursales')->on('sucursales')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_almacenes');
    }
};
