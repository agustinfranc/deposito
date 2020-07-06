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
            $table->integer('pedido_id');
            $table->integer('code');
            $table->string('detail');
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->tinyInteger('state')->default(0);
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
