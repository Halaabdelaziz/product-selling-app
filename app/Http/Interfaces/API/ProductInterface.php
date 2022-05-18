<?php 
namespace App\Http\Interfaces\API;

interface ProductInterface{
    public function index();
    public function getUserProducts();
    public function store($request);
    public function update($request,$id);
    public function destroy($id);
}