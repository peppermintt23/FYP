<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameStudentAndStaffIdInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('student_id', 'student_number');
            $table->renameColumn('staff_id', 'staff_number');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('student_number', 'student_id');
            $table->renameColumn('staff_number', 'staff_id');
        });
    }
}
