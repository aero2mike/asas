<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendingItems extends Model
{
    use HasFactory;

    protected $table = 'vending_items';
    public $timestamps  = false;

    public function vending()
    {
        return $this->belongsTo(Vendings::class,'id');
    }

    public function cartInventory()
    {
        return $this->belongsTo(CartInventory::class,'id'); 
    }
}
