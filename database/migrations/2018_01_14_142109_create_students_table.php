<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('student_id');
            $table->string('student_name',100);
            $table->date('date_of_birth');
            $table->integer('age');
            $table->string('email');
            $table->string('contact',100);
            $table->text('address');
            $table->string('city',100);
             $table->string('country',100);
            $table->date('date_of_register');
            $table->integer('class_id')->unsigned();
            $table->integer('section_id')->unsigned();
            $table->string('student_photo',100)->default(asset('assets/images/user.png'));;
            $table->timestamps();
            $table->foreign('class_id')->references('class_id')->on('tbl_classes');
            $table->foreign('section_id')->references('section_id')->on('sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
