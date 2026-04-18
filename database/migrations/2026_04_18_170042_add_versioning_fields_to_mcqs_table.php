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
        Schema::table('mcqs', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->nullable()->after('moduleID');
            $table->enum('source', ['manual', 'ai'])->default('manual')->after('group_id');
            $table->boolean('is_active')->default(true)->after('source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('mcqs', function (Blueprint $table) {
            $table->dropColumn(['group_id', 'source', 'is_active']);
        });
    }
};
