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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('idClientes');
            $table->string('nombreClientes')->nullable(false);
            $table->string('apellidoClientes')->nullable(false);
            $table->enum('tipodocumentoClientes', ['CC', 'CE', 'DNI', 'Pasaporte', 'Otro']);
            $table->string('numerodocumentoClientes')->nullable(false)->unique();
            $table->string('correoClientes');
            $table->string('celularClientes');
            $table->unsignedBigInteger('usersid');
            $table->foreign('usersid')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
