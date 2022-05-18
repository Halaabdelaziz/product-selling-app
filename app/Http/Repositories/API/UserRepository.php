<?php
namespace App\Http\Repositories\API;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Interfaces\API\UserInterface;

class UserRepository implements UserInterface{

    public function store($request){

        $user = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|confirmed',
            'phone'=>'required|string',
            'image'=>'required'
        ]);

        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('images'), $filename);
        }
        $userCreate = User::create([
            'name'=>$user['name'],
            'email'=>$user['email'],
            'password'=>Hash::make($user['password']),
            'phone'=>$user['phone'],
            'image'=>$user['image'],

        ]);

        return [
            $userCreate,
            'user created'
        ];
    }
    
    public function update($request){
        $userId = Auth::id();
        $user = User::where('id',$userId)->first();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('images'), $filename);
            $user->image = $filename;
        }
        $user->save();

        return [
            $user,
            'Updated'
        ];
    }
}