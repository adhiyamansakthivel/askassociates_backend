<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessApiResource;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        $business = Business::take(1)->first();
        
        return BusinessApiResource::make($business)->response()
        ->setStatusCode(200);
    }

}
