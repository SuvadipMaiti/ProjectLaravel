<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function create(Request $request){
        

        try{

            $post = new Post;
            $post->user_id = Auth::user()->id;
            $post->desc = $request->desc;

            //check if post has photo
            if($request->hasFile('photo'))
            {
                //create unique name for photo
                $photo = time().'jpg';
                //need to link storege folder to public
                $img_file = $request->photo;
                $img_new_name = time().$img_file->getClientOriginalName();
                $img_file->move('uploads/images',$img_new_name);
                $post->photo = $img_new_name;

            }
            $post->save();
            $post->user;
            return response()->json([
                'success' => true,
                'message' => 'successfully posted',
                'post' => $post
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
            $post = Post::find($request->id);
            //check user edit his own post or not
            if(Auth::user()->id != $post->user_id){
                return response()->json([
                    'success' => false,
                    'message' => 'unauthorized access'
                ]);

            }
            //check if post has photo
            if($request->hasFile('photo'))
            {

                $img_file = $request->photo;
                $img_new_name = time().$img_file->getClientOriginalName();
                //check if post has photo to delete
                if($img_new_name != $post->photo){
                    $image_path = public_path().'/uploads/images/'.$post->photo;
                    if(File::exists($image_path)) {
                        File::delete($image_path);
                    }
                    $img_file->move('uploads/images',$img_new_name);
                    $post->photo = $img_new_name;
                }
            } 
            $post->desc = $request->desc;
            $post->update();
            
            return response()->json([
                'success' => true,
                'message' => 'post updated'
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
            $post = Post::find($request->id);
            //check user edit his own post or not
            if(Auth::user()->id != $post->user_id){
                return response()->json([
                    'success' => false,
                    'message' => 'unauthorized access'
                ]);

            }
            //check if post has photo
            if($post->photo != '')
            {
                $image_path = public_path().'/uploads/images/'.$post->photo;
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }               
            } 
            $post->delete();
            return response()->json([
                'success' => true,
                'message' => 'post deleted'
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
        
    }


    public function posts(){
        $posts = Post::orderBy('id','desc')->get();
        foreach($posts as $post)
        {
            //get user of post
            $post->user;
            //comment count
            $post['commentsCount'] = count($post->comments);
            //likes count
            $post['likesCount'] = count($post->likes);
            //check if user likes his own post
            $post['selfLike'] = false;
            foreach($post->likes as $like){
                if($like->user_id == Auth::user()->id){
                    $post['selfLike'] = true;
                }
            }

        }

        return response()->json([
            'success' => true,
            'posts' => $posts
        ]);

    }





}
