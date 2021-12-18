<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeSet;
use App\Models\ProductCollection;
use App\Models\ProductWithAttribute;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        return response(["products" => Product::paginate(15)], 200);
    }


    public function getOneProduct($id)
    {


        if (request()->user() == null) {
            $result = Product::where('id', $id)->with(['attributes.sizeAttribute' => function ($query) {

                $query->where('attribute_set_id', 2);
            }])->get()->toArray();

            if ($result != null)
                $result[0] += ['is_wish_listed' => false];
        } else

            $result = Product::where('id', $id)->with(['attributes.sizeAttribute' => function ($query) {

                $query->where('attribute_set_id', 2);
            }])->get()->each(function ($items) {

                $items->append('is_wish_listed');
            })->toArray();


        if ($result == null)
            return response(["available" => false], 200);

        else {

            foreach ($result[0]['attributes'] as  $key => $value)
                if (is_null($value['size_attribute']))
                    unset($result[0]['attributes'][$key]);

            return response(["available" => true, "product" =>  $result], 200);
        }
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
