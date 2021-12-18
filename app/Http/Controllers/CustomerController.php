<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CustomerRegisterRequest;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {


        return ([
            'customer' => $request->user()

        ]);
    }
    public function store(CustomerRegisterRequest $request)
    {

        $data = $request->validated();

        // $otp = rand(100000, 999999);
        $otp = 000000;

        $customer = new Customer();

        $customer->name = $data['name'];
        $customer->phone = $data['phone'];
        $customer->email = $data['email'];
        $customer->otp_no = $otp;
        $insertedId = DB::table('ec_customers')->insertGetId(
            array(
                'name'     =>   $data['name'],
                'phone'   =>   $data['phone'],
                'password'   =>   Hash::make($data['phone']),
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

            // $otp = rand(100000, 999999);
            $otp = 000000;
            $customer = Customer::where('phone', $request->input('phone'))->first();
            $customer->otp_no = $otp;
            $customer->update();
            return response(["status" => true, "customer" => $customer, "otp_no" => $otp], 200);
        }
    }
    public function confrimOTP(CustomerRegisterRequest $request)
    {

        $data = $request->validated();

        $customer = Customer::where('phone', $data['phone'])->first();

        $customer->tokens()->delete();

        return response(["status" => true, "customer" => $customer, "token" => $customer->createToken($customer->name)->plainTextToken], 200);
    }
    public function validatePassword(Request $request)
    {

        if (Hash::check($request->input('password'), Customer::where('id', $request->user()->id)->get()->pluck('password')[0]))
            return response(["is_valid_password" => true], 200);
        else
            return response(["is_valid_password" => false], 200);
    }
}
