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
        Schema::table('mcqs', function (Blueprint $table) {
            $table->text('question')->after('moduleQs')->nullable();

            $table->string('answer1')->nullable();
            $table->string('answer2')->nullable();
            $table->string('answer3')->nullable();
            $table->string('answer4')->nullable();

            $table->integer('correct_answer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mcqs', function (Blueprint $table) {
            $table->dropColumn([
                'question',
                'answer1',
                'answer2',
                'answer3',
                'answer4',
                'correct_answer'
            ]);
        });
    }
};
