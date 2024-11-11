<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDB extends Model
{
    use HasFactory;
    protected $table = 'item_db';
    public $timestamps  = false;

    public function cartInventory()
    {
        return $this->hasMany(CartInventory::class, 'nameid');
    }
}
