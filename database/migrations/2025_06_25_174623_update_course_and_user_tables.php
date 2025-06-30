<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCourseAndUserTables extends Migration
{
    public function up(): void
    {
        // Drop columns
        Schema::table('courses', function (Blueprint $table) {
    // First drop the foreign key
    $table->dropForeign(['staff_id']);
    // Then drop the column
    $table->dropColumn('staff_id');
});

Schema::table('course_enrollment', function (Blueprint $table) {
    // First drop the foreign key if it exists
    $table->dropForeign(['student_id']);
    $table->dropColumn('student_id');
});


        // Add foreign keys to users table
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('course_enrollment_id')->nullable();
            $table->foreign('course_enrollment_id')->references('id')->on('course_enrollment')->onDelete('set null');

            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
        });
    }

    public function down(): void
    {
        // Revert changes
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('staff_id')->nullable(); // You can restore FK if needed
        });

        Schema::table('course_enrollment', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->nullable(); // You can restore FK if needed
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['course_enrollment_id']);
            $table->dropColumn('course_enrollment_id');

            $table->dropForeign(['course_id']);
            $table->dropColumn('course_id');
        });
    }
}
