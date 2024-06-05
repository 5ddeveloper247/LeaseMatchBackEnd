<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuControl extends Model
{
    use HasFactory;

    protected $table = 'menu_control';

    public function menu()
    {
    	return $this->belongsTo(Menu::class, 'menu_id');
    }
}
