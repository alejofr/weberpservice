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
        Schema::create('wse_monedas_cambios_tazas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->uuid('id_cambio_taza')->primary();
            $table->uuid('id_moneda_cambio');
            $table->string('id_cambio_taza_erp')->nullable();
            $table->string('monto_tc', 120);
            $table->date('fecha_tc');
            $table->boolean('eliminado')->default(false);
            $table->dateTime('fecha_creado');
            $table->dateTime('fecha_editado');
            $table->dateTime('fecha_eliminado')->nullable();


            $table->foreign('id_moneda_cambio')
                ->references('id_moneda_cambio')
                ->on('wse_monedas_cambios')
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
        Schema::dropIfExists('wse_monedas_cambios_tazas');
    }
};
