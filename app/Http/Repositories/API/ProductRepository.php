<?php 
namespace App\Http\Repositories\API;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\API\ProductResource;
use App\Http\Interfaces\API\ProductInterface;

class ProductRepository implements ProductInterface{

    // get all products by it's owner name
    public function index(){
        // $products = ProductResource::collection(Product::all());
        $products = Product::with('users')->get();
        return $products;
    }

    // get all poducts of login user
    public function getUserProducts(){
        $userId = Auth::id();
        $products = Product::where('user_id',$userId)->get();
        return $products;
    }

    // store new product by login user
    public function store($request){
        $user_id = Auth::check() ? Auth::user()->id : $request->user_id;

        $cred = $request->validate([
            'p_name'=>'required|string',
            'p_description'=>'required|string',
        ]);
        
        $product = Product::create([
            'p_name'=>$cred['p_name'],
            'p_description'=>$cred['p_description'],
            'user_id'=> $user_id,
        ]);

     
        if($request->has('images')){
        
            foreach ($request->file('images') as $image) {
                $imageName = $cred['p_name'].time().rand(1,1000).'.'.$image->extension();
                $image->move(public_path('images'), $imageName);
                Image::create([
                    'name'=>$imageName,
                    'product_id'=>$product->id,
                ]);
            }
        }
        return [
            $product,
            'stored'
        ];
    }

    // update product by id
    public function update($request,$id){
        // ============================ hint : when updating using raw data in postman
        $product = Product::find($id);
        if($request->p_name){
            $product->p_name = $request->p_name;
        }
        if($request->p_description){
            $product->p_description = $request->p_description;
        }
        $user_id = Auth::check() ? Auth::user()->id : $request->user_id;

        if($request->has('images')){
            foreach ($request->file('images') as $image) {
                $imageName = $request->p_name.time().rand(1,1000).'.'.$image->extension();
                $image->move(public_path('images'), $imageName);
                Image::create([
                    'name'=>$imageName,
                    'product_id'=>$product->id,
                ]);
            }
        }
        $product->save();
        return [
            $product,
            'Updated'
        ];


    }

    // delete product by id
    public function destroy($id){
        Product::destroy($id);
        return 'product has been deleted successfully';
    }
}
