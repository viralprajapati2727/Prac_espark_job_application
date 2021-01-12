<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('profile_id');
            $table->string('type',20)->nullable()->default(NULL);
            $table->string('nob',100)->nullable()->default(NULL);
            $table->string('year',10)->nullable()->default(NULL);
            $table->string('percentage',10)->nullable()->default(NULL);
            $table->string('course_name',100)->nullable()->default(NULL);
            $table->string('university',100)->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('education_details');
    }
}
