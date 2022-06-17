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
        Schema::create('wse_tipos_cambios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->uuid('id_tipo_cambio')->primary();
            $table->uuid('id_moneda_base');
            $table->uuid('id_moneda_cambio');
            $table->string('cambio', 60);
            $table->char('abreviatura_base', 36);
            $table->boolean('eliminado')->default(false);
            $table->dateTime('fecha_creado');
            $table->dateTime('fecha_editado');
            $table->dateTime('fecha_eliminado')->nullable();

            $table->foreign('id_moneda_base')
            ->references('id_moneda')
            ->on('wse_monedas')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->foreign('id_moneda_cambio')
            ->references('id_moneda')
            ->on('wse_monedas')
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
        Schema::dropIfExists('wse_tipos_cambios');
    }
};
