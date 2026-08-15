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
        Schema::create('productos', function (Blueprint $table) {
            $table->id('idProductos');
            $table->string('nombreProductos')->nullable(false);
            $table->text('descripcionProductos')->nullable();
            $table->decimal('precioProductos', 10, 2)->nullable(false);
            $table->enum('estadoProductos', ['Activo', 'Inactivo'])->nullable(false)->default('Activo');
            $table->unsignedBigInteger('categoriasid');
            $table->foreign('categoriasid')->references('idCategorias')->on('categorias')->onDelete('cascade');
            $table->unsignedBigInteger('marcasid');
            $table->foreign('marcasid')->references('idMarcas')->on('marcas')->onDelete('cascade');
            $table->unsignedBigInteger('unidadesmedidasid');
            $table->foreign('unidadesmedidasid')->references('idUnidadesMedidas')->on('unidades_medidas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
