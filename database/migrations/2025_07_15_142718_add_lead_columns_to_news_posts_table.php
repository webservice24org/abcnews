<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news_posts', function (Blueprint $table) {
            $table->boolean('is_lead')->default(false)->after('is_premium');
            $table->boolean('is_sub_lead')->default(false)->after('is_lead');
        });
    }

    public function down(): void
    {
        Schema::table('news_posts', function (Blueprint $table) {
            $table->dropColumn(['is_lead', 'is_sub_lead']);
        });
    }
};
