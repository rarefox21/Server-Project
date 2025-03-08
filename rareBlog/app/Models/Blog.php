<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [ 'title', 'content', 'user_id'];



    //relations

    public function comments()
    {
        return $this->hasMany(Comment::class)->with('user:id,name');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function upvotes()
    {
        return $this->votes()->where('vote', 1);
    }

    public function downvotes()
    {
        return $this->votes()->where('vote', 0);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
