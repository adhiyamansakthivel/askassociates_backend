<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryApiResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        
        return CategoryApiResource::collection($categories)->response()
        ->setStatusCode(200);
    }


    public function category_products()
    {
        $categories = Category::with('products')->withCount('products')->having('products_count', '>', 0)->get();
        
        return CategoryApiResource::collection($categories)->response()
        ->setStatusCode(200);
    }


    public function category_products_slug(Category $category)
    {
        $categories = Category::with('products')->withCount('products')->having('products_count', '>', 0)->find($category);
        
        return CategoryApiResource::collection($categories)->response()
        ->setStatusCode(200);
    }

}
