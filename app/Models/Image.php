<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'product_id',
        'uploadedBy'
    ];
    public function products(){
        return $this->belongsTo(Product::class);
    }
}
