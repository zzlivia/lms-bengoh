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
        Schema::create('moduleans', function (Blueprint $table) {
            $table->id('ansID');
            $table->foreignId('moduleQs_ID')->constrained('mcqs', 'moduleQs_ID')->onDelete('cascade');
            $table->text('ansID_text'); // the ans choice
            $table->boolean('ansCorrect')->default(false); // either the choice is correct
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moduleans');
    }
};
