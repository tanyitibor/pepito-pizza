<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePizzasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('pizzas', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('price_24cm');
            $table->integer('price_32cm');
            $table->integer('price_40cm');
            $table->string('image');
            $table->string('thumb_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('pizzas');
    }
}
