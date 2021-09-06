<?php

namespace App\Rules;

use App\Models\CustomerAddress;
use Illuminate\Contracts\Validation\Rule;

class UpdateCustomerAddressRule implements Rule
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
        $customerId = CustomerAddress::where('id', $value)->get()->pluck('customer_id');

        if ($customerId->count() > 0)
            if ($customerId[0] == request()->user()->id)
                return true;
            else {
                $this->error_message =  'Address doesn\'t belongs to you';
                return false;
            }
        else {
            $this->error_message = 'Invalid Address Id';
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->error_message;
    }
}
