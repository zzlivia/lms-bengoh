<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            // This creates 'translationable_id' and 'translationable_type'
            // It allows this row to link to a Course, a Module, or an MCQ
            $table->morphs('translationable'); 
            
            $table->string('locale'); // 'en', 'ms', etc.
            $table->string('key');    // 'name', 'description', 'question'
            $table->text('value');    // The actual translated text
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
