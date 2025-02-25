<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = ["from_id", "to_id", "content", "read_at"];

    public function sender()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
}
