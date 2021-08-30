<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'ec_customers';

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'otp_no', 'remember_token', 'created_at', 'updated_at'
    ];
    public function wishListProducts()
    {
        return $this->belongsToMany(Product::class, 'ec_wish_lists', 'customer_id', 'product_id')->withTimestamps();
    }
    
}
