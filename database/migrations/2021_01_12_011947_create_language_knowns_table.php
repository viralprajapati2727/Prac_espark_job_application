<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageKnownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_knowns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('profile_id');
            $table->integer('language_id');
            $table->tinyInteger('is_read')->nullable()->default(NULL)->comment('0 = No,1 = Yes');
            $table->tinyInteger('is_write')->nullable()->default(NULL)->comment('0 = No,1 = Yes');
            $table->tinyInteger('is_speak')->nullable()->default(NULL)->comment('0 = No,1 = Yes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_knowns');
    }
}
