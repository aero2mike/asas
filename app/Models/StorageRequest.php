<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageRequest extends Model
{
    use HasFactory;
    protected $table = 'storage_request';
    protected $primaryKey = 'id';
    public $timestamps  = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'master_id');
    }

}
