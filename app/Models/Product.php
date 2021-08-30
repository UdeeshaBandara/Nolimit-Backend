<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'ec_products';

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pivot'
    ];

    public function productCollection()
    {
        return $this->belongsToMany(ProductCollection::class, 'ec_product_collection_products', 'product_id', 'product_collection_id');
    }
    public function wishListCustomers()
    {
        return $this->belongsToMany(Customer::class, 'ec_wish_lists', 'product_id', 'customer_id')->withTimestamps();
    }
}
