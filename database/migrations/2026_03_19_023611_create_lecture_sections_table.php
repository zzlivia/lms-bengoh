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
        Schema::create('lecture_sections', function (Blueprint $table) {
            $table->id('sectionID'); // Primary Key
            $table->foreignId('lectID')->constrained('lecture', 'lectID')->onDelete('cascade');
            $table->string('section_title');
            $table->string('section_type');
            $table->text('section_content')->nullable();
            $table->string('section_file')->nullable();
            $table->integer('section_order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_sections');
    }
};
