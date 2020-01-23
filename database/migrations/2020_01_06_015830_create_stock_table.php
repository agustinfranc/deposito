<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rubro');
            $table->string('subrubro')->nullable();
            $table->integer('codigo');
            $table->string('detalle');
            $table->tinyInteger('specs')->default(0);
            $table->tinyInteger('spec1_estado')->nullable();
            $table->string('spec1_nombre')->nullable();
            $table->string('spec1_datos')->nullable();
            $table->tinyInteger('spec2_estado')->nullable();
            $table->string('spec2_nombre')->nullable();
            $table->string('spec2_datos')->nullable();
            $table->tinyInteger('spec3_estado')->nullable();
            $table->string('spec3_nombre')->nullable();
            $table->string('spec3_datos')->nullable();
            $table->tinyInteger('spec4_estado')->nullable();
            $table->string('spec4_nombre')->nullable();
            $table->string('spec4_datos')->nullable();
            $table->tinyInteger('spec5_estado')->nullable();
            $table->string('spec5_nombre')->nullable();
            $table->string('spec5_datos')->nullable();
            $table->tinyInteger('comentario')->default(0);
            $table->tinyInteger('comentario1')->nullable();
            $table->integer('cantidad')->default(0);
            $table->decimal('precio', 8, 2);
            $table->string('usuario_alta');
            $table->string('usuario_edicion')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
