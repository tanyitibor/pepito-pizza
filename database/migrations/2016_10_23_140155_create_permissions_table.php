<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('permissions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->boolean('see_orders')->default(true);
            $table->boolean('modify_orders')->default(false);
            $table->boolean('modify_pizzas')->default(false);
            $table->boolean('modify_toppings')->default(false);
            $table->boolean('modify_employees')->default(false);
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
        //
        Schema::dropIfExists('permissions');
    }
}
