<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote4Points extends Model
{
    use HasFactory;
    protected $table = 'vote_points';

    protected $fillable = [
        'master_acc_id',
        'rank_id',
        'ip',
        'mac_address',
        'delay_expire',
    ];
}
