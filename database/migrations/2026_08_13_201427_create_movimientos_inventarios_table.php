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
        Schema::create('movimientos_inventarios', function (Blueprint $table) {
            $table->id('idMovimientosInventario');
            $table->enum('tipoMovimientoInventario', ['Entrada', 'Salida', 'Ajuste'])->default('Entrada');
            $table->integer('cantidadMovimientoInventario');
            $table->datetime('fechaMovimientoInventario');
            $table->text('observacionesMovimientoInventario')->nullable();
            $table->unsignedBigInteger('productoid');
            $table->foreign('productoid')->references('idProductos')->on('productos')->onDelete('cascade');
            $table->unsignedBigInteger('sucursalid');
            $table->foreign('sucursalid')->references('idSucursales')->on('sucursales')->onDelete('cascade');
            $table->unsignedBigInteger('usersid');
            $table->foreign('usersid')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('proveedoresid');
            $table->foreign('proveedoresid')->references('idProveedores')->on('proveedores')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventarios');
    }
};
