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
        Schema::create('assessment_mcq_options', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('assQsID');
            $table->string('optionText');
            $table->boolean('is_correct')->default(false);

            $table->timestamps();

            //the foreign key
            $table->foreign('assQsID')->references('assQsID')->on('assessment_qs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_mcq_options');
    }
};
