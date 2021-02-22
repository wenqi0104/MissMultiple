<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_exercises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('multiplier');
            $table->integer('multiplicand');
            $table->integer('product');
            $table->integer('marks');
            $table->integer('hide')->nullable()->default(1);
            $table->string('mcq')->nullable();
            $table->timestamps();
            $table->integer('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_exercises');
    }
}
