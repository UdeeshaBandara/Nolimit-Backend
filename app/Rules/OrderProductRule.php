<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class OrderProductRule implements Rule
{
    public $error_message;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $outofstockList = array();
        foreach (request()->input('products', array()) as $cartItem) {

            $product = Product::find($cartItem['product_id']);
            if (!$product->isOutOfStock($cartItem['qty'])) {

                $this->error_message = 'Product out of stock - id : '.$cartItem['product_id'];
                return false;
                //     $weight += ($product->weight * $cartItem['qty']);

                // if ($product) {
                //     $rawTotal += ($cartItem['qty'] * ($product->priceTax == 0 ? $product->price : $product->priceTax));
                // }


                // $this->error_message = (string)$outofstockList ;


            } else {
              
            }
        }
       
        

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function  message()
    {
        return $this->error_message;
    }
}
