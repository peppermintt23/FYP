<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCourseEnrollmentIdFromUsersTable extends Migration
{
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Drop foreign key first (use the constraint name)
        $table->dropForeign(['course_enrollment_id']);
        // Then drop the column
        $table->dropColumn('course_enrollment_id');
    });
}


    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('course_enrollment_id')->nullable();
        });
    }
}
