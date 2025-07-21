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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Menu label
            $table->string('type'); // category / subcategory / division / custom
            $table->unsignedBigInteger('type_id')->nullable(); // The id of the category, subcategory, division, etc.
            $table->integer('order')->default(0); // To store order for sorting
            $table->unsignedBigInteger('parent_id')->nullable(); // <-- just add column here, no foreign key yet
            $table->timestamps();
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
