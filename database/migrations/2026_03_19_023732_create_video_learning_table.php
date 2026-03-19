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
        Schema::create('videolearning', function (Blueprint $table) {
            $table->id('videoLearningID'); 
            $table->foreignId('learningMaterialID')->constrained('learningmaterials', 'learningMaterialID')->onDelete('cascade');
            $table->string('videoLearningName');
            $table->string('videoLearningPath');
            $table->text('videoLearningDesc')->nullable();
            $table->integer('videoLearningDuration'); // minutes
            $table->string('videoLearningResolution'); // e.g., '1080p'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videolearning');
    }
};
