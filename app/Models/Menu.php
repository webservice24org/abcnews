<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
   


    protected $fillable = [
        'title',     // Menu label
        'type',      // category / subcategory / division / custom
        'type_id',   // related id (category_id, subcategory_id, etc.)
        'order',     // menu order/position
        'parent_id', // parent menu id for submenu
    ];

    // Relationship: parent menu
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // Relationship: child menus (submenus)
    public function children()
{
    return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
}


}
