<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Post;

class Comment extends Model
{
        //relationship
        public function user(){
            return $this->belongsTo(User::class);
        }
    
        
        //relationship
        public function post(){
            return $this->belongsTo(Post::class);
        }
    

}
