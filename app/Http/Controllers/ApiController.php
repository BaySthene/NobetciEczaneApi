<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CurlController;

class ApiController extends Controller
{

    public static function getPharmacy(CurlController $curl,$city)
    {

        $data = $curl->index($city);
        return response()->json([
            "Data" => $data,
        ],200)
        ->header('Content-Type', 'text/plain');

    }
}
