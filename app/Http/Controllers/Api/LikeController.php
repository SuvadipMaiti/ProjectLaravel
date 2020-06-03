<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Like;
use Exception;

use Illuminate\Support\Facades\Auth;


class LikeController extends Controller
{
    public function like(Request $request){
        try{
            $like = Like::where('post_id',$request->id)->orderBy('id','desc')->get();
            //check post  already liked or not
            
            if(count($like) > 0){
                $like[0]->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'unliked'
                ]);
            }

            $like = new Like;
            $like->user_id = Auth::user()->id;
            $like->post_id = $request->id;
            $like->save();

            return response()->json([
                'success' => true,
                'message' => 'liked'
            ]);

        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
        

    }
}
