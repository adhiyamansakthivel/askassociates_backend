<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarouselApiResource;
use App\Models\Carousel;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    public function index()
    {
        return CarouselApiResource::collection(Carousel::orderBy('created_at', 'asc')->limit(6)->get());

    }
}
