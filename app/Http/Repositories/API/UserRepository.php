<?php
namespace App\Http\Repositories\API;

use App\Models\User;
use App\Mail\UserEmail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        if($request->has('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('images'), $filename);
          
        }

        $userCreate = User::create([
            'name'=>$user['name'],
            'email'=>$user['email'],
            'password'=>Hash::make($user['password']),
            'phone'=>$user['phone'],
            'image'=>$filename,

        ]);

        return [
            $userCreate,
            'user created'
        ];
    }
    // function to update login user info
    public function update($request){
        // ============================ hint : when updating using raw data in postman
        $userId = Auth::id();
        $user = User::where('id',$userId)->first();

        if($request->name){
            $user->name = $request->name;
        }
        if($request->email){
            $user->email = $request->email;
        }
        if($request->phone){
            $user->phone = $request->phone;
        }
        if($request->has('image')){
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

// send email to users
    public function sendEmail($request)
    {
        $users = User::whereIn("id", $request->ids)->get();
        $product = Product::where('id',$request->id)->first();
        foreach ($users as $key => $user) {
            Mail::to($user->email)->send(new UserEmail($user,$product));
        }

        /*
        Hint:
        send request via raw in postman as the following
        {
            "ids":[1,2],
            "id":2
        }
        */
        return response()->json(['success'=>'Send email successfully.']);
    }
}