<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Comment;
use App\Like;

class Post extends Model
{


        //relationship
        public function user(){
            return $this->belongsTo(User::class);
        }

        
        //relationship
        public function comments(){
            return $this->hasMany(Comment::class);
        }

        //relationship
        public function likes(){
            return $this->hasMany(Like::class);
        }
}
