<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // Run: php artisan make:migration add_group_course_to_exercises_table --table=exercises

    public function up()
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->string('groupCourse')->nullable();   // class/group name (A, B, C, etc.)
            $table->unsignedBigInteger('lecturer_id')->nullable(); // link to users table if needed
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exercises', function (Blueprint $table) {
            //
        });
    }
};
