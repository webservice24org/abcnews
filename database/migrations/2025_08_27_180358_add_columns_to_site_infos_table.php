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
        Schema::table('site_infos', function (Blueprint $table) {
            $table->string('office_address')->nullable()->after('id');
            $table->string('email')->nullable()->after('office_address');
            $table->string('mobile')->nullable()->after('email');
            $table->string('editor')->nullable()->after('mobile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_infos', function (Blueprint $table) {
            $table->dropColumn(['office_address', 'email', 'mobile', 'editor']);
        });
    }
};
