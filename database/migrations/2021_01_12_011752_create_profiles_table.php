<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('first_name',100)->nullable()->default(NULL);
            $table->string('last_name',100)->nullable()->default(NULL);
            $table->text('address1')->nullable()->default(NULL);
            $table->text('address2')->nullable()->default(NULL);
            $table->string('state',50)->nullable()->default(NULL);
            $table->string('city',50)->nullable()->default(NULL);
            $table->string('postcode',50)->nullable()->default(NULL);
            $table->string('phone',50)->nullable()->default(NULL);
            $table->date('dob')->nullable()->default(NULL);
            $table->string('gender',20)->nullable()->default(NULL);
            $table->string('relation',20)->nullable()->default(NULL);
            $table->string('notice_period',50)->nullable()->default(NULL);
            $table->string('expected_ctc',50)->nullable()->default(NULL);
            $table->string('current_ctc',50)->nullable()->default(NULL);
            $table->integer('department_id')->nullable()->default(NULL);
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
        Schema::dropIfExists('profiles');
    }
}
