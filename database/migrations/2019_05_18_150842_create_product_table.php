<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('product_id');
            $table->bigInteger('product_code')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('product_name', 100);
            $table->string('product_brand', 50);
            $table->bigInteger('purchase_price')->unsigned();
            $table->integer('discount')->unsigned();
            $table->bigInteger('selling_price')->unsigned();
            $table->integer('product_stock')->unsigned();
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
        Schema::dropIfExists('product');
    }
}
