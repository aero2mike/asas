<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartInventory extends Model
{
    use HasFactory;
    protected $table = 'cart_inventory';
    public $timestamps  = false;

    public function char()
    {
        return $this->belongsTo(Char::class);
    }

    public function itemDB()
    {
        return $this->belongsTo(ItemDB::class, 'nameid');
    }
    
    public function vendingItems()
    {
        return $this->hasMany(VendingItems::class, 'cartinventory_id');
    }

}
