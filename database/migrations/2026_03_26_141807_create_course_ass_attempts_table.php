<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseAssAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('courseAssAttempts', function (Blueprint $table) {
            $table->bigIncrements('attemptID');

            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('courseAssID');

            $table->integer('score')->nullable();
            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();

            $table->foreign('userID')
                ->references('userID')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('courseAssID')
                ->references('courseAssID')
                ->on('course_assessments')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courseAssAttempts');
    }
};
