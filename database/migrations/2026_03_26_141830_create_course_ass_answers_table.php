<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseAssAnswersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('courseAssAnswers', function (Blueprint $table) {
            $table->bigIncrements('answersAssID');

            $table->unsignedBigInteger('attemptID');
            $table->unsignedBigInteger('assQsID');

            $table->unsignedBigInteger('selected_option_id')->nullable();
            $table->text('answer_text')->nullable();

            $table->boolean('is_correct')->nullable();

            $table->timestamps();

            $table->foreign('attemptID')
                ->references('attemptID')
                ->on('courseAssAttempts')
                ->onDelete('cascade');

            $table->foreign('assQsID')
                ->references('assQsID')
                ->on('assessment_qs')
                ->onDelete('cascade');

            $table->foreign('selected_option_id')
                ->references('id')
                ->on('assessment_mcq_options')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courseAssAnswers');
    }
};
