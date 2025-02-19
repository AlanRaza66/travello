<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    //
    protected $fillable = ["comment", "user_id", "post_id", "comment_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function isMyComment()
    {
        return Auth::user()->id === $this->user_id;
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, "comment_user", "comment_id", "user_id");
    }

    public function likesTotal()
    {
        return $this->likes()->count();
    }

    public function isLiked()
    {
        return $this->likes()->where("comment_id", $this->id)->where('user_id', Auth::user()->id)->exists();
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function answers()
    {
        return $this->hasMany(Comment::class);
    }

    public function countAnswers() {
        return $this->answers()->count();
    }
}
