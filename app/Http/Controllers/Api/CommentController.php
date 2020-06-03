<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comment;
use Exception;

use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create(Request $request){
        try{

            $comment = new Comment;
            $comment->user_id = Auth::user()->id;
            $comment->post_id = $request->id;
            $comment->comment = $request->comment;
            $comment->save();

            return response()->json([
                'success' => true,
                'message' => 'Comment Added',
                'comment' => $comment
            ]);

        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }


    }



    public function update(Request $request){
        try{
            $comment = Comment::find($request->id);
            //check user edit his own comment or not
            if(Auth::user()->id != $comment->user_id){
                return response()->json([
                    'success' => false,
                    'message' => 'unauthorized access'
                ]);

            }
            $comment->comment = $request->comment;
            $comment->update();
            
            return response()->json([
                'success' => true,
                'message' => 'comment updated'
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
        
    }


    public function delete(Request $request){
        try{
            $comment = Comment::find($request->id);
            //check user edit his own post or not
            if(Auth::user()->id != $comment->user_id){
                return response()->json([
                    'success' => false,
                    'message' => 'unauthorized access'
                ]);

            }

            $comment->delete();
            return response()->json([
                'success' => true,
                'message' => 'comment deleted'
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
        
    }

    public function comments(Request $request){
        try{
            $comments = Comment::where('post_id',$request->id)->orderBy('id','desc')->get();
            foreach($comments as $comment)
            {
                //get user of post
                $comment->user;
            }
    
            return response()->json([
                'success' => true,
                'comments' => $comments
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
        

    }


}
