<?php 
namespace App\Http\Repositories\API;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\API\ProductResource;
use App\Http\Interfaces\API\ProductInterface;

class ProductRepository implements ProductInterface{
    public function index(){
        // $products = ProductResource::collection(Product::all());
        $products = Product::with('users')->get();
        return $products;
    }

    public function getUserProducts(){
        $userId = Auth::id();
        $products = Product::where('user_id',$userId)->get();
        return $products;
    }
    public function store($request){

        $cred = $request->validate([
            'p_name'=>'required|string',
            'p_description'=>'required|string',
            'user_id'=>'required',
        ]);
        
        $product = Product::create([
            'p_name'=>$cred['p_name'],
            'p_description'=>$cred['p_description'],
            'user_id'=>$cred['user_id'],
        ]);

        return [
            $product,
            'stored'
        ];

    }
    public function update($request,$id){
       
        $product = Product::find($id);
        $product->p_name = $request->p_name;
        $product->p_description = $request->p_description;
        $product->user_id = $request->user_id;
        $product->save();
        dd($product);

        return [
            $product,
            'Updated'
        ];


    }
    public function destroy($id){
        Product::destroy($id);
        return 'product has been deleted successfully';
    }
}
