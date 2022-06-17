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
        Schema::create('wse_proveedores_condiciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->uuid('id_proveedor_condicion')->primary();
            $table->uuid('id_proveedor');
            $table->uuid('id_condicion_proveedor');
            $table->string('id_proveedor_condicion_erp')->nullable();
            $table->boolean('eliminado')->default(false);
            $table->dateTime('fecha_creado');
            $table->dateTime('fecha_editado');
            $table->dateTime('fecha_eliminado')->nullable();

            $table->foreign('id_proveedor')
                ->references('id_proveedor')
                ->on('wse_paises')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_empresa')
                ->references('id_empresa')
                ->on('wse_empresas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wse_proveedores_condiciones');
    }
};
