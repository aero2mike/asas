<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickLog extends Model
{
    use HasFactory;
    protected $table = "picklog";
    public $timestamps = false;


    protected $fillable = ['id','time', 'char_id', 'type', 'nameid', 'item_name', 'amount', 'refine', 'card0', 'card1', 'card2','card3'];

}
