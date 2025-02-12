<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'bio',
        'isPublic',
        'password',
        'slug'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Summary of following
     * Get all users who i follow
     * @return BelongsToMany<User, User>
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'follower_user', 'follower_id', 'user_id');
    }

    /**
     * Summary of following
     * Get all users who follow me
     * @return BelongsToMany<User, User>
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follower_user', 'user_id', 'follower_id');
    }

    /**
     * Summary of isFollowed
     * Verify if i follow
     * @param \App\Models\User $user
     * @return bool
     */
    public function isFollowing(User $user): bool
    {
        return $this->following()->where('follower_id', $this->id)->where("user_id", $user->id)->exists();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->belongsToMany(Post::class, 'post_user', 'user_id', 'post_id');
    }

    public function liked(Post $post): bool
    {
        return $this->likes()->where("post_id", $post->id)->exists();
    }
}
