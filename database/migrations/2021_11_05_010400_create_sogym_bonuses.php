<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSogymBonuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sogym_bonuses', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->string("phone");
            $table->longText("amount")->nullable();
            $table->integer("bonus")->nullable();

        
            $table->integer("card_number")->nullable();
            $table->longText("pay_date")->nullable();
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
        Schema::dropIfExists('sogym_bonuses');
    }
}
