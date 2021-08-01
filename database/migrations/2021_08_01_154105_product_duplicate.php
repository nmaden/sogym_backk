<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductDuplicate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_duplicate', function (Blueprint $table) {
                $table->id();

                $table->longText("name_product")->nullable();
                $table->integer("c_id")->nullable();
                $table->string("article")->nullable();
                $table->string("category_id")->nullable();
                $table->integer("price")->nullable();
                $table->integer("count")->nullable();

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
    }
}
