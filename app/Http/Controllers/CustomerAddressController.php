<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CustomerAddressController extends Controller
{

    public function index(Request $request)
    {
        $addresses = Customer::find($request->user()->id)->addresses()->get();

        if ($addresses->isEmpty())
            return response(["available" => false], 200);
        else
            return response(["available" => true, 'addresses' => $addresses], 200);
    }
    public function store(AddressRequest $addressRequest)
    {
        $data = $addressRequest->validated();
        $address =  new CustomerAddress();
        
        $address->name = $data['name'];
        $address->email = $data['email'];
        $address->phone = $data['phone'];
        $address->address = $data['address'];
        $address->city = $data['city'];
        $address->state = '';
        $address->country = '';
        $address->customer_id = $addressRequest->user()->id;
        $address->is_default = '0';


        $status =  $address->save();

        if ($status)
            return response(["status" => $status, "address" => $address], 201);
        else
            return response(["status" => $status], 200);
    }
    public function destory(AddressRequest $addressRequest)
    {

        $data = $addressRequest->validated();
        if (Customer::find($addressRequest->user()->id)->addresses()->where('id', $data['id'])->delete())
            return response(["status" => true], 200);
        else
            return response(["status" => false], 200);
    }
    public function patch(AddressRequest $addressRequest)
    {
        $data = $addressRequest->validated();
        $address =   CustomerAddress::find($data['id']);

        $address->name = $data['name'];
        $address->email = $data['email'];
        $address->phone = $data['phone'];
        $address->address = $data['address'];
        $address->city = $data['city'];
        $address->state = '';
        $address->country = '';
        $address->customer_id = $addressRequest->user()->id;
        $address->is_default = '0';


        $status =  $address->save();

        if ($status)
            return response(["status" => $status, "address" => $address], 200);
        else
            return response(["status" => $status], 200);
    }
    public function getCities(Request $request)
    {

        $states = State::where("description", "like", '%' . $request->input('city') . '%')->get();

        if ($states->isEmpty())
            return response(["available" => false], 200);
        else
            return response(["available" => true, 'states' => $states], 200);
    }
}
