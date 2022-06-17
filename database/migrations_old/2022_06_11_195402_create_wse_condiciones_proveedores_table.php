<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wse_condiciones_proveedores', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->uuid('id_condicion_proveedor')->primary();
            $table->string('id_condicion_proveedor_erp')->nullable();
            $table->string('largo_condicion', 80)->unique();
            $table->string('corto_condicion', 40)->nullable();

            $table->boolean('eliminado')->default(false);
            $table->dateTime('fecha_creado');
            $table->dateTime('fecha_editado');
            $table->dateTime('fecha_eliminado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wse_condiciones_proveedores');
    }
};
