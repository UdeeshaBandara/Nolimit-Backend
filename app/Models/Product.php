<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'ec_products';

    protected $guarded = [];

    protected $attributes = [
        'options' => 'default value'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pivot'
    ];


    protected $casts = [
        'images' => 'array'
    ];


    public function productCollection()
    {
        return $this->belongsToMany(ProductCollection::class, 'ec_product_collection_products', 'product_id', 'product_collection_id');
    }
    public function wishListCustomers()
    {
        return $this->belongsToMany(Customer::class, 'ec_wish_lists', 'product_id', 'customer_id')->withTimestamps();
    }
    public function reviews()
    {

        return $this->hasMany(Review::class,  'product_id');
    }
    public function getIsReviewedAttribute()
    {

        return $this->reviews()->where('customer_id', request()->user()->id)
            ->exists();
    }
    public function isOutOfStock($qty = null)
    {

        if (!$this->with_storehouse_management) {

            return false;
        }

        if ($qty != null && $qty > $this->quantity) {

            return true;
        }

        return $this->quantity <= 0 && !$this->allow_checkout_when_out_of_stock;
    }
    public function productCategory()
    {
        return $this->belongsToMany(Category::class, 'ec_product_category_product', 'product_id', 'category_id');
    }


    public function attributes()
    {

         
        return $this->hasMany(ProductWithAttribute::class);
    }
    public function getIsWishListedAttribute()
    {

        return $this->wishListCustomers()->where('customer_id', request()->user()->id)
            ->exists();
    }
}
