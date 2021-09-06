<?php

namespace App\Http\Requests;

use App\Rules\UpdateCustomerAddressRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddressRequest extends FormRequest
{
      /**
     * Failed validation disable redirect
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response(["status" => false, "validation_error" => $validator->errors()->first()], 200));
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->method() == "POST") {
            return [
                'address' => 'bail|required|max:255',
                'city' => 'bail|required|max:255',
                'state' => 'bail|required|max:255',
                'country' => 'bail|required|max:255',
                'is_default' => 'bail|required|numeric',

            ];
        }else if(request()->method()=="DELETE"){
            return [
                'id' => 'bail|required|max:255',
                
               

            ];

        
        }else if(request()->method()=="PUT"){
            return [
                'id' => 'bail|required|exists:ec_customer_addresses,id|max:255',
                'id' => new UpdateCustomerAddressRule(),
                'address' => 'bail|required|max:255',
                'city' => 'bail|required|max:255',
                'state' => 'bail|required|max:255',
                'country' => 'bail|required|max:255',
                'is_default' => 'bail|required|numeric',
                
               

            ];

        }
    }
}
