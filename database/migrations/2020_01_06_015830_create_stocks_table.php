<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rubro');
            $table->string('subrubro')->nullable();
            $table->integer('code')->unique();
            $table->string('detail')->unique();
            $table->mediumInteger('quantity')->default(0);
            $table->decimal('price', 8, 2);
            $table->unsignedInteger('creator_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('creator_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
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
