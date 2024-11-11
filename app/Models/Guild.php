<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    use HasFactory;
    protected $table = 'guild';
    protected $primaryKey = 'guild_id';
    public $timestamps  = false;

    protected $fillable = [
        'guild_id',
        'name',
        'master',
        'guild_lv',
        'connect_member',
        'max_member',
        'average_lv',
        'exp',
        'next_exp',
        'skill_point',
        'mes1',
        'mes2',
        'emblem_len',
        'emblem_id',
        'emblem_data',
        'last_leader_change',
    ];
}
