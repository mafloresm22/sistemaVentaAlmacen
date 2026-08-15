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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id('idProveedores');
            $table->string('nombreProveedores', 150);
            $table->enum('tipodocumentoProveedores', ['DNI', 'RUC'])->default('DNI');
            $table->string('numeroDocumentoProveedores', 20);
            $table->string('direccionProveedores', 255);
            $table->string('telefonoProveedores', 20)->nullable();
            $table->string('correoProveedores', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
