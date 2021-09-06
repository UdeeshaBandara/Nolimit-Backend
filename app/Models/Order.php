<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'ec_orders';

    protected $guarded = [];

    public function products(){

        return $this->belongsToMany(Product::class, 'ec_order_product', 'order_id','product_id')->withPivot('qty', 'price')->withTimestamps();
    

 
    }



}
