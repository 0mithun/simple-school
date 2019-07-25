<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentMarkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_marks', function (Blueprint $table) {
            $table->increments('student_mark_id');
            $table->integer('exam_id')->unsigned();
            $table->integer('class_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->integer('mark');
            $table->timestamps();
            
            
            
            $table->foreign('exam_id')->references('exam_id')->on('exams');
            $table->foreign('class_id')->references('class_id')->on('tbl_classes');
            $table->foreign('subject_id')->references('subject_id')->on('subjects');
            $table->foreign('student_id')->references('student_id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_marks');
    }
}
