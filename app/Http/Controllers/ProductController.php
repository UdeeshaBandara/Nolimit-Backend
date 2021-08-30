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

        // $result->makeHidden(['description','content']); 
        // $result = Product::where('sale_price', '>', 0)->paginate(15);
        // $result = Product::where('sale_price', '>', 0)->take(10)->get();

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
    public function test()
    {

        $params = array_merge([
            'collections' => [
                'by' => 'id',
                'value_in' => [],
            ],
            'condition' => [
                'ec_products.status' => 'published',
                'ec_products.is_variation' => 0,
            ],
            'order_by' => [
                'ec_products.order' => 'ASC',
                'ec_products.created_at' => 'DESC',
            ],
            'take' => null,
            'paginate' => [
                'per_page' => null,
                'current_paged' => 1,
            ],
            'select' => [
                'ec_products.*',
            ],
            'with' => [],
        ], [
            'select' => [
                'ec_products.*',
                'ec_products.images as images_url',
            ],
            'collections' => [
                'by' => 'id',
                'value_in' => [1],
            ],
            'paginate' => [
                'per_page' => 10,
                'current_paged' => 1
            ]
        ]);


       $res =  Product::join('ec_product_collection_products', 'ec_products.id', '=', 'ec_product_collection_products.product_id')
            ->join(
                'ec_product_collections',
                'ec_product_collections.id',
                '=',
                'ec_product_collection_products.product_collection_id'
            )
            ->distinct()
            ->where(function ($query) use ($params) {
                /**
                 * @var Builder $query
                 */
                // if (!$params['collections']['value_in']) {
                return $query;
            })->get();


            return response(["available" => $res,"quer"=>$params], 200);
    }
}
