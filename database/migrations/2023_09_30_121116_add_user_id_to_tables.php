<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
        });

        Schema::table('genres', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
        });

        Schema::table('actors', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('genres', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('actors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
