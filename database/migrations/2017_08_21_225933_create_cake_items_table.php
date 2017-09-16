<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCakeItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cake_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_cake_id')->unsigned();
            $table->foreign('category_cake_id')->references('id')->on('category_cakes');
            $table->string('item');
            $table->string('path');
            $table->text('description');
            $table->decimal('price', 5, 2);
            $table->string('volume')->nullable();
            $table->boolean('show')->default(1);
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
        Schema::dropIfExists('cake_items');
    }
}
