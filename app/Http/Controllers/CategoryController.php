<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slug;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {

        $cat_list = array(
            array(
                'text' => 'All Products',
                'slug' => 'all',
                'image' => 'categories/All Products.png'
            ),
            array(
                'text' => 'Women',
                'slug' => 'women',
                'image' => 'categories/Women.png'
            ),
            array(
                'text' => 'Men',
                'slug' => 'men',
                'image' => 'categories/Men.png'
            ),
            array(
                'text' => 'Kids',
                'slug' => 'kids-1',
                'image' => 'categories/Kids.png'
            ),
            array(
                'text' => 'Plus Size',
                'slug' => 'plus-sizes',
                'image' => 'categories/Plus Size.png'
            ),
            array(
                'text' => 'Accessories',
                'slug' => 'accessories',
                'image' => 'categories/Accesories.png'
            ),
            array(
                'text' => 'Homeware',
                'slug' => 'homeware',
                'image' => 'categories/Homeware.png'
            ),
            array(
                'text' => 'Backpacks & Bags',
                'slug' => 'backpacks-and-sport-bags',
                'image' => 'categories/Backpack.png'
            ),
            array(
                'text' => 'Bathware',
                'slug' => 'bathware',
                'image' => 'categories/Bathware-07.png'
            ),
            array(
                'text' => 'Swimwear',
                'slug' => 'swimwear',
                'image' => 'categories/Swimwear.png'
            ),
            array(
                'text' => 'Umbrella',
                'slug' => 'umbrellas',
                'image' => 'categories/Umbrella.png'
            ),
            array(
                'text' => 'Gift Vouchers',
                'slug' => 'gift-vouchers',
                'image' => 'categories/Gift Vouchers.png'
            ),
        );
        return response(["status" => true, "categories" => $cat_list], 200);
    }
    public function getProductByCategory($categorySlug)
    {


        if ($categorySlug == 'all')
            $result = Product::paginate(15);
        else {
            $categoryId = Slug::where('key', $categorySlug)
                ->where('reference_type', 'Botble\\Ecommerce\\Models\\ProductCategory')->first()->reference_id;
                
            $result = Category::find($categoryId)->products()->paginate(15);
        }




        return response(["status" => true, "categories" => $result], 200);
    }
}
