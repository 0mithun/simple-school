<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_settings', function (Blueprint $table) {
            $table->increments('result_setting_id');
            $table->integer('exam_id')->unsigned();
            $table->integer('class_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->integer('mark_greater_than');
            $table->integer('mark_less_than');
            $table->string('grade',100);
            $table->timestamps();
            
            $table->foreign('exam_id')->references('exam_id')->on('exams');
            $table->foreign('class_id')->references('class_id')->on('tbl_classes');
            $table->foreign('subject_id')->references('subject_id')->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('result_settings');
    }
}
