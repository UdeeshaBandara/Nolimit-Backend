<?php

namespace App\Rules;

use App\Models\Order;
use Illuminate\Contracts\Validation\Rule;

class ReviewStoreRule implements Rule
{
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

        $pass = false;


        Order::where('status', 'completed')->where('user_id', request()->user()->id)->with('products')->get()->each(function ($items)  use (&$pass, $value) {
            return $items->products->each(function ($item) use (&$pass, $value) {

                if ($item->id == $value) {
                    $pass =  true;
                    return false;
                } 
            });
        });
      
        if ($pass)
            return true;
        else
            return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You haven\'t purchased this product';
    }
}
