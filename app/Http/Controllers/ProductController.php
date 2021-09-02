<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        return response(["products" => Product::paginate(15)], 200);
    }


    public function getOneProduct($id)
    {
        $result = Product::find($id);
        if ($result == null)
            return response(["available" => false], 200);
        else
            return response(["available" => true, "product" =>  $result], 200);
    }

    public function getFlashSale()
    {
        $result = Product::where('sale_price', '>', 0)->where('is_variation', 0)->where('sale_type', 1)->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->take(10)->get();

        if ($result->isEmpty())
            return response(["available" => false], 200);
        else
            return response(["available" => true, "products" =>  $result], 200);
    }


    public function getFeaturedProduct()
    {
        $result = Product::where('status', "published")
            ->where('is_featured', 1)
            ->orderBy('created_at', 'desc')->take(10)->get();


        if ($result->isEmpty())
            return response(["available" => false], 200);
        else
            return response(["available" => true, "products" =>  $result], 200);
    }


    public function getNewArrivals()
    {
        $result = ProductCollection::find(1)->products()->get();

        if ($result->isEmpty())
            return response(["available" => false], 200);
        else
            return response(["available" => true, "products" =>  $result], 200);
    }

    
}
