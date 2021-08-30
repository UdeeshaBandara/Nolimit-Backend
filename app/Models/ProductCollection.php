<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCollection extends Model
{
    use HasFactory;
    protected $table = 'ec_product_collections';

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class,'ec_product_collection_products','product_collection_id','product_id');
    }

}
