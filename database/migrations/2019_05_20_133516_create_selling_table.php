<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selling', function (Blueprint $table) {
            $table->increments('selling_id');
            $tabel->bigInteger('member_code')->unsigned();
            $table->integer('total_item')->unsigned();
            $table->bigInteger('total_price')->unsigned();
            $table->integer('discount')->unsigned();
            $table->bigInteger('pay')->unsigned();
            $table->bigInteger('received')->unsigned();
            $table->integer('users_id')->unsigned();
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
        Schema::dropIfExists('selling');
    }
}
