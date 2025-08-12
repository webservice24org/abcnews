<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('color_settings', function (Blueprint $table) {
            $table->string('footer_bg')->nullable()->after('title_hover_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('color_settings', function (Blueprint $table) {
            $table->dropColumn('footer_bg');
        });
    }
};
