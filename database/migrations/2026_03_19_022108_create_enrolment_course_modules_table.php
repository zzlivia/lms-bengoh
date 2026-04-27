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
        Schema::create('enrolmentcoursemodules', function (Blueprint $table) {
            $table->id('enrollID');
            $table->foreignId('userID')->constrained('users', 'userID');
            $table->foreignId('courseID')->constrained('course', 'courseID')->cascadeOnDelete();;
            $table->foreignId('moduleID')->constrained('module', 'moduleID');
            $table->boolean('isCompleted')->default(false);
            $table->boolean('inProgress')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrolmentcoursemodules');
    }
};
