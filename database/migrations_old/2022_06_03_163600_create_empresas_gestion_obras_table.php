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
        Schema::create('empresas_gestion_obras', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->uuid('id_empresa_gestion_obra')->primary();
            $table->uuid('id_empresa');
            $table->string('id_empresa_gestion_obra_erp')->nullable();
            $table->string('nombre', 80)->unique();
            $table->string('clave', 60)->unique();
            $table->string('ceco', 60);
            
            $table->boolean('eliminado')->default(false);
            $table->dateTime('fecha_creado');
            $table->dateTime('fecha_editado');
            $table->dateTime('fecha_eliminado')->nullable();
            $table->foreign('id_empresa')
            ->references('id_empresa')
            ->on('empresas')
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
        Schema::dropIfExists('empresas_gestion_obras');
    }
};
