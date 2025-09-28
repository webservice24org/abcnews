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
        Schema::table('under_construction', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('end_time'); 
            // 1 = active, 0 = inactive
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('under_construction', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
