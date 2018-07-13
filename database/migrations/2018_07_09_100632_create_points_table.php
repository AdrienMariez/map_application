<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->primary('id')->unique();
            $table->string('link');
            $table->string('icon');
            $table->string('color');
            $table->float('longitude', 8, 2);
            $table->float('lattitude', 8, 2);
            $table->boolean('uses_image');
            $table->string('image_path');
            $table->integer('fk_reference_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('points');
    }
}
