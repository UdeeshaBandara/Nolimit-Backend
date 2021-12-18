<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'ec_product_categories';

    protected $guarded = [];
    public function products()
    {
        return $this->belongsToMany(Product::class,'ec_product_category_product', 'category_id','product_id' );
    }

}
