<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WikiPost extends Model
{
    use HasFactory;
    protected $table = "x_wiki_posts";
    protected $fillable = ['id','category_id','title','slug','description','body','author','icon','created_at','updated_at','archive'];
    

    public function category()
    {
        return $this->belongsTo(WikiCategories::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class,'id');
    }

    public function scopeNotArchived($query)
    {
        return $query->where('archive', 0);
    }

    public function scopeArchive($query)
    {
        return $query->where('archive', 1);
    }

}