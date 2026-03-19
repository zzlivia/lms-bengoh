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
        Schema::create('learningmaterials', function (Blueprint $table) {
            $table->id('learningMaterialID');
            $table->foreignId('lectID')->constrained('lecture', 'lectID')->onDelete('cascade');
            $table->string('learningMaterialTitle');
            $table->text('learningMaterialDesc');
            $table->string('learningMaterialType'); // e.g., 'pdf' or 'video'
            $table->string('storagePath');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learningmaterials');
    }
};
