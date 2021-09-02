<?php

namespace App\Http\Controllers;

use App\Models\MediaFolder;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function getHomeBanners(){

        $result = MediaFolder::find(5)->mediaFiles()->take(5)->pluck('url');


        if ($result->isEmpty())
            return response(["available" => false], 200);
        else
            return response(["available" => true, "banners" =>  $result], 200);

    }
}
