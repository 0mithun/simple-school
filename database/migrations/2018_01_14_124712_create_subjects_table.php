<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('subject_id');
            $table->string('subject_name',100);
            $table->integer('marks');
            $table->integer('teacher_id')->unsigned();
            $table->integer('class_id')->unsigned();
            $table->timestamps();
            $table->foreign('class_id')->references('class_id')->on('tbl_classes');
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
