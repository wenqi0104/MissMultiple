<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',191);
            $table->string('marks');
            $table->timestamps();

            $table->string('questions')->nullable();
            $table->string('correct_answers')->nullable();
            $table->integer('user_id');
            $table->integer('material_id');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercises');
    }
}
