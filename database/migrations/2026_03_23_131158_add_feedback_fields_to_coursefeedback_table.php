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
        Schema::table('coursefeedback', function (Blueprint $table) {
            $table->string('clarity')->nullable();
            $table->string('understanding')->nullable();
            $table->string('favorite_module')->nullable();
            $table->text('enjoyed')->nullable();
            $table->text('suggestions')->nullable();
            $table->unsignedBigInteger('userID')->nullable();
            $table->integer('rating')->nullable(); // ⭐ 1–5 stars
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coursefeedback', function (Blueprint $table) {
            $table->dropColumn([
                'clarity',
                'understanding',
                'favorite_module',
                'enjoyed',
                'suggestions',
                'userID',
                'rating'
            ]);
        });
    }
};
