<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

Route::get('/getpharmacy/{city}', [ApiController::class, 'getPharmacy'])->where('city','[a-z]+')->name('getPharmacy');