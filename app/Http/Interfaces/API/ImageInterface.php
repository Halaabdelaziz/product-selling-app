<?php
namespace App\Http\Interfaces\API;
interface ImageInterface{
    public function index();
    public function store($request);
    public function update($request,$id);
    public function destroy($id);
}