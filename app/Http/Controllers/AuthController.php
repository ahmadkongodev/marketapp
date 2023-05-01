<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   public function register(Request $request){
        $attributs = $request->validate([
            'name' => 'required|string',
            'username'=> 'required|string',
            'phone'=>'required|unique:users,phone',
            'password'=>'required|min:6|confirmed',
        ]);

        $user=User::create([
            'name'=>$attributs['name'],
            'username'=>$attributs['username'],
            'phone'=>$attributs['phone'],
            'password'=>bcrypt($attributs['password']),

        ]);
        return response([
            'user'=>$user,
            'token'=>$user->createToken('secret')->plainTextToken
        ]);

    }
    public function login(Request $request){
        $attributs = $request->validate([
            'username'=> 'required|string',
            'password'=>'required|min:6',
        ]);

         if(!Auth::attempt($attributs))
         {
            return response([
                'message'=>'Invalid credentials.'
            ],403);
         }
        return response([
            'user'=>auth()->user(),
            'token'=>auth()->user()->createToken('secret')->plainTextToken
        ],200);
        
    }
    public function logout(){
        auth()->user()->tokens()->delete();
        return response([
            'message'=>'Logout success.'
        ],200);
    }
    public function user(){
        return response(
            [
                'user'=>auth()->user()
            ],200
        );
    }
    public function update(Request $request){
        $attributs=$request->validate([
            'name' => 'required|string',
            'username'=> 'required|string',
            'phone'=>'required|unique:users,phone',
        ]);
        $image = $this->saveImage($request->image,'profiles');
        auth()->user()->update([
            'name'=>$attributs['name'],
            'username'=>$attributs['username'],
            'phone'=>$attributs['phone'],
            'image'=>$image,
        ]);
        return response(
            [
                'message'=>'User updated',
                'user'=>auth()->user()
            ],200
        );
    }
}
