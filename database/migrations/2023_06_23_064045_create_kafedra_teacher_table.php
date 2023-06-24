<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kafedra_teacher', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('kafedra_id');
            $table->unsignedBigInteger('teacher_id');
            
            $table->foreign('kafedra_id')->references('id')->on('kafedra');
            $table->foreign('teacher_id')->references('id')->on('teacher');

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
        Schema::dropIfExists('kafedra_teacher');
    }
};
