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
        Schema::create('course', function (Blueprint $table) {
            $table->id('courseID');
            $table->string('courseCode')->unique();
            $table->string('courseName');
            $table->string('courseAuthor');
            $table->text('courseDesc');
            $table->string('courseCategory');
            $table->string('courseLevel');
            $table->string('courseDuration');
            $table->boolean('isAvailable')->default(true);
            $table->string('courseImg')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course');
    }
};
