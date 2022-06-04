<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('p_name');
            $table->string('description');
            $table->integer('num_bids');
            $table->integer('deposite');
            $table->integer('old_price');
            $table->integer('new_price');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('location');
            $table->integer('user_id');
            $table->integer('cat_id');


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
        Schema::dropIfExists('products');
    }
}
