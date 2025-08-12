<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColorSetting extends Model
{
    protected $fillable = [
        'header_bg',
        'nav_item_color',
        'sub_menu_bg',
        'sub_menu_hover_bg',
        'menu_hover',
        'sub_menu_hover',
        'sec_title_bg',
        'sec_title_color',
        'sec_border_color',
        'cat_btn_bg',
        'cat_btn_color',
        'title_color',
        'title_hover_color',
        'footer_bg',
        'copyright_text_color',
        'dev_text_color',
        'social_icon_bg',
        'social_icon_color',
        'social_icon_hover_bg',
    ];
}
