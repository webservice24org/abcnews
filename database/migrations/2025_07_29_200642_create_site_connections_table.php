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
        Schema::create('site_connections', function (Blueprint $table) {
            $table->id();
            $table->string('google_verification')->nullable();
            $table->string('bing_verification')->nullable();
            $table->string('baidu_verification')->nullable();
            $table->string('pinterest_verification')->nullable();
            $table->string('yandex_verification')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_connections');
    }
};
