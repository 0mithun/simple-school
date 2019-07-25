<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('teacher_id');
            $table->string('name',100);
            $table->string('email',100);
            $table->string('photo',100)->default(asset('assets/images/user.png'));
            $table->date('date_of_birth');
            $table->integer('age');
            $table->string('contact',100);
            $table->text('address');
            $table->string('city');
            $table->string('country');
            $table->integer('job_type');
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
        Schema::dropIfExists('teachers');
    }
}
