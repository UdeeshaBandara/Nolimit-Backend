<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWithAttribute extends Model
{
    use HasFactory;

    protected $table = 'ec_product_with_attribute';

    protected $guarded = [];


    protected $hidden = [
        'id','attribute_id','product_id'
    ];

 
    public function sizeAttribute()
    {

        return $this->hasOne(ProductAttribute::class,'id');
    }
    
   
   
    
   


}
