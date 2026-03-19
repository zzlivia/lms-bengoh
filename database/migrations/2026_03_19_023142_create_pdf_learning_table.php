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
        Schema::create('pdflearning', function (Blueprint $table) {
            $table->id('pdfLearningID');
            $table->string('pdfLearningName');
            $table->string('pdfLearningPath');
            $table->text('pdfLearningDesc')->nullable();
            $table->integer('pdfLearningPages');
            $table->string('pdfLearningSizes');
            $table->foreignId('learningMaterialID')->constrained('learningmaterials', 'learningMaterialID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdflearning');
    }
};
