<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // use HasFactory;

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {               
        return $this->hasMany(Comment::class);
    }
    public function reacts()
    {
        return $this->hasMany(React::class);
    }
}
