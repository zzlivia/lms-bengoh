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
        Schema::create('assessment_qs', function (Blueprint $table) {
            $table->id('assQsID');

            $table->unsignedBigInteger('courseAssID');
            $table->text('courseAssQs');

            //ENUM
            $table->enum('courseAssType', [
                'MCQ',
                'SHORT_ANSWER',
                'LONG_ANSWER'
            ]);

            $table->timestamps();

            //the foreign key
            $table->foreign('courseAssID')->references('courseAssID')->on('course_assessments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_qs');
    }
};
