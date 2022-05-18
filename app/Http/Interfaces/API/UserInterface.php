<?php 
namespace App\Http\Interfaces\API;
interface UserInterface{

    public function store($request);
    public function update($request);

}