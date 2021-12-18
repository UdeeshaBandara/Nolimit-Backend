<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Rules\ReviewDeleteRule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use stdClass;

use function PHPUnit\Framework\isEmpty;

class ReviewController extends Controller
{

    public function index(Request $request)
    {


        $productList = [];

        $orders = Order::where('status', 'completed')->where('user_id', $request->user()->id)->with(['products', 'products.reviews' => 
        function ($query) use ($request)  {
           
            $query->where('customer_id', $request->user()->id);
        }])->get()->each(function ($items) {

            $items->products->append('is_reviewed');
           
        });

        foreach ($orders as $order)

            foreach ($order->products as $product){
                $product->setAttribute( 'purchased_price',$product->pivot->price);
                $product->setAttribute( 'purchased_qty',$product->pivot->qty);
                array_push($productList, $product);
            }

        if ($orders->isEmpty())
            return response(["available" => false], 200);
        else
            return response(["available" => true, 'products' => $productList], 200);
            
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
