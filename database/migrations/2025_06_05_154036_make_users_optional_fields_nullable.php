<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->change();
            $table->string('position')->nullable()->change();
            $table->string('room_number')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable(false)->change();
            $table->string('position')->nullable(false)->change();
            $table->string('room_number')->nullable(false)->change();
        });
    }
};
