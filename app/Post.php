<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Comments;
use App\Like;

class Post extends Model
{
    protected $fillable = [
        'title',
        'description',
        'img'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
