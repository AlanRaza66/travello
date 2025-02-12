<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    //
    protected $fillable = ["description", "picture", "location", "user_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_user', 'post_id', 'user_id');
    }

    public function likesTotal()
    {
        return $this->likes()->count();
    }

    public function isLiked()
    {
        return $this->likes()->where("post_id", $this->id)->where('user_id', Auth::user()->id)->exists();
    }
}
