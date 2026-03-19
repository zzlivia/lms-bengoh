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
        Schema::create('community_stories', function (Blueprint $table) {
            $table->id('id');
            $table->string('community_name');
            $table->string('title');
            $table->text('community_story');
            $table->string('community_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('adminID')->constrained('admin', 'adminID')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_stories');
    }
};
