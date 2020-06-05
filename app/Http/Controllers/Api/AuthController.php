<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWTAuth as JWTAuthJWTAuth;

class AuthController extends Controller
{


    public function login(Request $request){

        $credentials = $request->only('email','password');
        if(!$token = Auth::attempt($credentials)){
            return response()->json([
                'success' => false,
                'message' => 'Invalid credential'
            ], 401);
        }
        return response()->json([
            'success' =>true,
            'token' => $token,
            'user' => Auth::user()
        ]);

    }

    
    public function register(Request $request){

        $encryptePass = Hash::make($request->password);

        $user = new User;

        try{
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $encryptePass;
            $user->save();

            return $this->login($request);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }

    }

    public function logout(Request $request){
        try{
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json([
                'success' => true,
                'message' => 'logout successfull'
            ], 401);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
     

    }

    public function profile(Request $request){
        
        try{
            $user = User::find(Auth::user()->id);
            $user->name = $request->name;
            
            //check if post has photo
            if($request->hasFile('photo'))
            {
                
                $img_file = $request->photo;
                $img_new_name = time().$img_file->getClientOriginalName();
                //check if post has photo to delete
                if($img_new_name != $user->photo){
                    $image_path = public_path().'/uploads/images/'.$user->photo;
                    if(File::exists($image_path)) {
                        File::delete($image_path);
                    }
                    $img_file->move('uploads/images',$img_new_name);
                    $user->photo = $img_new_name;
                }
            } 
            $user->update();
            
            return response()->json([
                'success' => true,
                'message' => 'Profile updated'
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }

    }
    
}
