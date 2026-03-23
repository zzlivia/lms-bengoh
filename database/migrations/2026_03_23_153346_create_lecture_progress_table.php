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
        Schema::create('lectureprogress', function (Blueprint $table) {
            $table->bigIncrements('lectProgressID');
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('lectID');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['userID', 'lectID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectureprogress');
    }
};
