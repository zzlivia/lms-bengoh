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
        Schema::create('lecture_section_translations', function (Blueprint $table) {
            $table->id();
            //link to lecture_sections
            $table->unsignedBigInteger('sectionID');
            //languages
            $table->string('locale');
            //translated content
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
            // foreign key
            $table->foreign('sectionID')
                ->references('sectionID')
                ->on('lecture_sections')
                ->onDelete('cascade');
            // prevent duplicate translations
            $table->unique(['sectionID', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_section_translations');
    }
};
