<?php

namespace App\Http\Requests;

use App\Rules\ReviewDeleteRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReviewRequest extends FormRequest
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
                'product_id' => 'bail|required|numeric|exists:ec_products,id|unique:ec_reviews,product_id,product_id,id,customer_id,' . request()->user()->id,
                'comment' => 'bail|required|max:255',
                'rating' => 'bail|required|numeric',

            ];
        }else if(request()->method()=="DELETE"){
            return [
                'product_id' => 'bail|required|numeric',
                'product_id' => new ReviewDeleteRule()
               

            ];

        }
    }
    public function messages()
    {

        return [
            'unique' => 'You already reviewed this product'
        ];
    }
}
