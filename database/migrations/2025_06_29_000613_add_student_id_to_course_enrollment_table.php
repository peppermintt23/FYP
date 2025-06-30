<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Ensure the student_id column exists (safe check done outside)
        if (!Schema::hasColumn('course_enrollment', 'student_id')) {
            Schema::table('course_enrollment', function (Blueprint $table) {
                $table->unsignedBigInteger('student_id')->after('id');
            });
        }

        // Then add the foreign key constraint
        Schema::table('course_enrollment', function (Blueprint $table) {
            $table->foreign('student_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('course_enrollment', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            // Optional: also drop the column
            // $table->dropColumn('student_id');
        });
    }
};
