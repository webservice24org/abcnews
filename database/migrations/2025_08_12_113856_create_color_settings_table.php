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
        Schema::create('color_settings', function (Blueprint $table) {
            $table->id();
            $table->string('header_bg')->nullable();
            $table->string('nav_item_color')->nullable();
            $table->string('sub_menu_bg')->nullable();
            $table->string('sub_menu_hover_bg')->nullable();
            $table->string('menu_hover')->nullable();
            $table->string('sub_menu_hover')->nullable();
            $table->string('sec_title_bg')->nullable();
            $table->string('sec_title_color')->nullable();
            $table->string('sec_border_color')->nullable();
            $table->string('cat_btn_bg')->nullable();
            $table->string('cat_btn_color')->nullable();
            $table->string('title_color')->nullable();
            $table->string('title_hover_color')->nullable();
            $table->string('copyright_text_color')->nullable();
            $table->string('dev_text_color')->nullable();
            $table->string('social_icon_bg')->nullable();
            $table->string('social_icon_color')->nullable();
            $table->string('social_icon_hover_bg')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_settings');
    }
};
