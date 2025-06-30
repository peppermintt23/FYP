<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // If you have a FK constraint, drop it first:
            $table->dropForeign(['course_id']);
            // Then drop the column:
            $table->dropColumn('course_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Re-create column (adjust type as needed):
            $table->unsignedBigInteger('course_id')->nullable();
            // Re-add FK constraint if you had one:
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
        });
    }
};
