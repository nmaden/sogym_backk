<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application', function (Blueprint $table) {
            $table->id();
            $table->integer('purcase_id')->nullable();
            $table->string('name',512)->nullable();
            $table->string('bin',512)->nullable();
            $table->string('address',512)->nullable();
            $table->integer('phone')->nullable();
            $table->string('email',512)->nullable();
            $table->string('link_file')->nullable();
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
        Schema::dropIfExists('application');
    }
}
