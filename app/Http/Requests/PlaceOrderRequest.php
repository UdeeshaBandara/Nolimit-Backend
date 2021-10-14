<?php

namespace App\Http\Requests;

use App\Rules\OrderProductRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlaceOrderRequest extends FormRequest
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
        return [
            'ship_address_id' => ['bail', 'required', 'numeric','exists:ec_customer_addresses,id'],
            'products' => ['bail', 'required'  ],
            'products.*.product_id' => ['bail', 'required', 'numeric','exists:ec_products,id',new OrderProductRule() ],
            'products.*.qty' => ['bail', 'required', 'numeric'],
            // 'products' => ['bail', 'required', new OrderProductRule()],
            'billing_address_id' => ['bail', 'required', 'numeric','exists:ec_customer_addresses,id'],
            

        ];
    }
    public function messages()
    {

        return [
            'products.*.product_id.exists' => 'Invalid product id - :input' //use :attribute to return field name
        ];
    }
}
