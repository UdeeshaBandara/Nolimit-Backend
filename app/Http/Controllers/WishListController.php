<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class WishListController extends Controller
{

    public function index(Request $request)
    {
        
        $result = Customer::find($request->user()->id)->wishListProducts()->get();
        if ($result->isEmpty())
            return response(["available" => false], 200);
        else
            return ([
                'available' => true,
                'products' =>  $result]);
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_id' => 'bail|required|numeric|unique:ec_wish_lists,product_id,product_id,id,customer_id,' . $request->user()->id
        ], ['unique' => 'Product is already in your wishlist']);

        if ($validator->fails())
            return response(["status" => false, "validation_error" => $validator->errors()->first()], 200);
        else {

            $request->user()->wishListProducts()->attach($request->input('product_id'));
            return response(["status" => true, "message" => 'Product successfully added to wishlist'], 200);
        }
    }
    public function destroy(Request $request)
    {

        $validator = Validator::make($request->all(), ['product_id' => 'bail|required|numeric']);

        if ($validator->fails())
            return response(["status" => false, "validation_error" => $validator->errors()->first()], 200);
        else {
            if ($request->user()->wishListProducts()->detach($request->input('product_id')))
                return response(["status" => true, "message" => 'Product removed from wishlist'], 200);
            else
                return response(["status" => true, "message" => 'This Product not available in your wishlist'], 200);
        }
    }
}
