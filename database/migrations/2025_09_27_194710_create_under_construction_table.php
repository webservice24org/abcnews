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
         Schema::create('under_construction', function (Blueprint $table) {
            $table->id();
            $table->string('banner_text'); 
            $table->timestamp('start_time')->nullable(); 
            $table->timestamp('end_time')->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('under_construction');
    }
};
