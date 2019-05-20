<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->increments('setting_id');
            $table->string('company_name', 100);
            $table->text('company_address');
            $table->string('company_phone_number', 20);
            $table->string('company_logo', 50);
            $table->string('member_card', 50);
            $table->integer('member_discount')->unsigned();
            $table->integer('note_type')->unsigned();
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
        Schema::dropIfExists('setting');
    }
}
