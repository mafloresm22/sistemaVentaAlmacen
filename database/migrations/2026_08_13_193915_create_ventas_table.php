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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id('idVentas');
            $table->string('codigoVentas', 20)->unique();
            $table->decimal('totalVentas', 10, 2);
            $table->datetime('fechaVentas');
            $table->enum('estadoVentas', ['Pagada', 'Pendiente', 'Cancelada', 'Reembolsada'])->default('Pagada');
            $table->unsignedBigInteger('clienteid');
            $table->foreign('clienteid')->references('idClientes')->on('clientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
