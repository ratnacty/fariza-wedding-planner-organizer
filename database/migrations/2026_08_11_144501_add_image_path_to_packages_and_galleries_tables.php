<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('cover_color');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('cover_color');
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
};
