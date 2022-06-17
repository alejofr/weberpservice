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
        Schema::create('wse_facturas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->uuid('id_factura')->primary();
            $table->uuid('id_proveedor');
            $table->uuid('id_ceco');
            $table->uuid('id_moneda');
            $table->string('id_factura_erp')->nullable();
            $table->date('fecha_factura')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->string('monto_factura', 80);
            $table->text('descripcion_factura')->nullable();

            $table->boolean('eliminado')->default(false);
            $table->dateTime('fecha_creado');
            $table->dateTime('fecha_editado');
            $table->dateTime('fecha_eliminado')->nullable();

            $table->foreign('id_proveedor')
            ->references('id_proveedor')
            ->on('wse_op_proveedores')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('id_ceco')
            ->references('id_ceco')
            ->on('wse_cecos')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('id_moneda')
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
        Schema::dropIfExists('wse_facturas');
    }
};
