<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('section_id');
            $table->string('section_name',50);
            $table->integer('class_id')->unsigned();
            $table->integer('teacher_id')->unsigned();
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
        Schema::dropIfExists('sections');
    }
}
