<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_assessments', function (Blueprint $table) {
            $table->id('courseAssID');
            
            $table->unsignedBigInteger('courseID');
            $table->string('courseAssTitle');
            $table->text('courseAssDesc')->nullable();

            $table->timestamps();

            //the foreign keys
            $table->foreign('courseID')->references('courseID')->on('course')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_assessments');
    }
};
