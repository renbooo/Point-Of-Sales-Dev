<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selling_details', function (Blueprint $table) {
            $table->increments('selling_details_id');
            $table->integer('selling_id')->unsigned();
            $table->bigInteger('product_code')->unsigned();
            $table->bigInteger('selling_price')->unsigned();
            $table->integer('total')->unsigned();
            $table->integer('discount')->unsigned();
            $table->bigInteger('sub_total')->unsigned();
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
        Schema::dropIfExists('selling_details');
    }
}
