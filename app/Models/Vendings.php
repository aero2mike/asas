<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendings extends Model
{
    use HasFactory;

    protected $table = 'vendings';
    public $timestamps  = false;

    public function char()
    {
        return $this->belongsTo(Char::class);
    }

    public function login()
    {
        return $this->belongsTo(GameAccount::class);
    }

    public function vendingItems()
    {
        return $this->hasMany(VendingItems::class, 'vending_id');
    }

}
