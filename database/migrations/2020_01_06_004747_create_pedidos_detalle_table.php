<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_detalle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_pedido');
            $table->integer('codigo');
            $table->string('detalle');
            $table->tinyInteger('specs');
            $table->tinyInteger('spec1');
            $table->tinyInteger('spec2');
            $table->tinyInteger('spec3');
            $table->tinyInteger('comentario');
            $table->tinyInteger('comentario1');
            $table->integer('cantidad');
            $table->decimal('precio', 8, 2);
            $table->tinyInteger('estado')->default(0);
            $table->tinyInteger('checked')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos_detalle');
    }
}
