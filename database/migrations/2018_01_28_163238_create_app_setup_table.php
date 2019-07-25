<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_setups', function (Blueprint $table) {
            $table->increments('app_setup_id');
            $table->string('app_title',100)->nullable();
            $table->text('app_description')->nullable();
            $table->string('copyright_title',100)->nullable();
            $table->string('app_logo',100)->nullable();
            $table->string('app_favicon',100)->nullable();
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
        Schema::dropIfExists('app_setups');
    }
}
