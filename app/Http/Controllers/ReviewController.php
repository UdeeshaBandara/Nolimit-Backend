<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Customer;
use App\Models\Review;
use App\Rules\ReviewDeleteRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{

    public function index(Request $request)
    {

        $result = Customer::find($request->user()->id)->reviews()->with('product')->get();

        if ($result->isEmpty())
            return response(["available" => false], 200);
        else
            return response(["available" => true, "reviews" => $result], 200);
            
    }
    public function store(ReviewRequest $request)
    {
        $data = $request->validated();

        $review = new Review();

        $review->customer_id = $request->user()->id;
        $review->product_id = $data['product_id'];
        $review->comment = $data['comment'];
        $review->star = $data['rating'];
        $review->status = 'published';
        $status = $review->save();

        if ($status)

            return response(["status" => $status, "review" => $review], 200);
        else
            return response(["status" => $status], 200);
    }
    public function destory(ReviewRequest $request)
    {
        $data = $request->validated();

        if (Review::where('product_id', $data['product_id'])->where('customer_id', $request->user()->id)->delete())
            return response(["status" => true, "message" => 'Review removed'], 200);
    }
}
