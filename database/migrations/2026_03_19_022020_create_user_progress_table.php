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
        Schema::create('userprogress', function (Blueprint $table) {
            $table->id('progressID');
            $table->foreignId('userID')->constrained('users', 'userID');
            $table->foreignId('courseID')->constrained('course', 'courseID');
            $table->string('progressName');
            $table->string('progressStatus');
            $table->integer('completionProgress'); // percentage
            $table->timestamp('lastAccessed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userprogress');
    }
};
