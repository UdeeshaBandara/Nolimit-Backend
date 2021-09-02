<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'ec_reviews';

    protected $guarded = [];

    /**
     * The attributes that should be map for arrays.
     *
     * @var array
     */
  
    protected $appends = ['review_id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id','customer_id', 'product_id', 'created_at', 'updated_at'
    ];


    public function getReviewIdAttribute()
    {
        return $this->attributes['id'];
    }

    public function product()
    {

        return $this->belongsTo(Product::class);
    }
}
