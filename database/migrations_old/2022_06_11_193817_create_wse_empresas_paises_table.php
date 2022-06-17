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
        Schema::create('wse_empresas_paises', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->uuid('id_empresa_pais')->primary();
            $table->uuid('id_empresa');
            $table->uuid('id_pais');
            $table->string('id_empresa_pais_erp')->nullable();

            $table->boolean('eliminado')->default(false);
            $table->dateTime('fecha_creado');
            $table->dateTime('fecha_editado');
            $table->dateTime('fecha_eliminado')->nullable();

            $table->foreign('id_pais')
                ->references('id_pais')
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
        Schema::dropIfExists('wse_empresas_paises');
    }
};
