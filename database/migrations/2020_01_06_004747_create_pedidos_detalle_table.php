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
            $table->tinyInteger('specs')->default(0);
            $table->string('spec1')->nullable();
            $table->string('spec2')->nullable();
            $table->string('spec3')->nullable();
            $table->tinyInteger('comentario')->default(0);
            $table->string('comentario1')->nullable();
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
