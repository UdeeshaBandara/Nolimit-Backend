<?php

namespace App\Http\Requests;

use App\Rules\OTPConfirmRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerRegisterRequest extends FormRequest
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
        if (strpos(request()->requestUri, 'customer/confirm-otp')) {
            
            return [
                'phone' => ['bail', 'required', 'numeric','exists:ec_customers,phone'],
                'otp_no' => ['bail', 'required', 'numeric','digits:6', new OTPConfirmRule()]

            ];
        } else
            return [
                'name' => 'bail|required|max:255',
                'email' => 'bail|required|unique:ec_customers,email|max:255|email',
                'phone' => 'bail|required|unique:ec_customers,phone',
            ];
    }
}
