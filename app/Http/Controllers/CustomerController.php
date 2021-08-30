<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CustomerRegisterRequest;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $response = $request->user();
        // $response = $response->makeHidden(['otp_no', 'remember_token', 'created_at', 'updated_at']);

        return ([
            'customer' => $response

        ]);
    }
    public function store(CustomerRegisterRequest $request)
    {

        $data = $request->validated();

        $otp = rand(100000, 999999);

        $customer = new Customer();

        $customer->name = $data['name'];
        $customer->phone = $data['phone'];
        $customer->email = $data['email'];
        $customer->otp_no = $otp;
        $insertedId = DB::table('ec_customers')->insertGetId(
            array(
                'name'     =>   $data['name'],
                'phone'   =>   $data['phone'],
                'email'   =>   $data['email'],
                'created_at'   =>  Carbon::now(),
                'updated_at'   =>   Carbon::now(),
                'otp_no'   =>   $otp
            )
        );
        $customer->id =  $insertedId;

        return response(["status" => true, "customer" => $customer, "otp_no" => $otp], 200);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'bail|required|numeric|exists:ec_customers,phone'
        ]);
        if ($validator->fails()) {
            return response(["status" => false, "validation_error" => $validator->errors()->first()], 200);
        } else {

            $otp = rand(100000, 999999);
            $customer = Customer::where('phone', $request->input('phone'))->first();
            $customer->otp_no = $otp;
            $customer->update();
            return response(["status" => true, "customer" => $customer, "otp_no" => $otp], 200);
        }
    }
    public function confrimOTP(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'bail|required|numeric|exists:ec_customers,phone',
            'otp_no' => 'bail|required|numeric|digits:6'
        ]);
        if ($validator->fails()) {
            return response(["status" => false, "validation_error" => $validator->errors()->first()], 200);
        } else {

            $customer = Customer::where('phone', $request->input('phone'))->first();
            if ($request->input('otp_no') == $customer->otp_no) {
                $authToken = "";
                
                if ($customer->tokens()->count() == 0)
                    $authToken = $customer->createToken($customer->name)->plainTextToken;
                else {
                    $customer->tokens()->where('tokenable_id', $customer->id)->delete();
                    $authToken = $customer->createToken($customer->name)->plainTextToken;
                }
                return response(["status" => true, "customer" => $customer, "token" => $authToken], 200);
            } else {
                return response(["status" => false, "validation_error" => "Invalid OTP code"], 200);
            }
        }
    }
}
