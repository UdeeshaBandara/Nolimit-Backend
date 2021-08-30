<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SanctumController extends Controller
{
    function indicate()
    {
        dd("sanctum contoller");
        return [
            "logged-in-status" => "false",
        ];
    }
}
