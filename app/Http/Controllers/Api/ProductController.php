<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductApiResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('brand', 'category')
        ->orderBy('created_at', 'desc')->get();
        
        return ProductApiResource::collection($products)->response()
        ->setStatusCode(200);
    }


    public function related_products(Request $request, string $product_id, string $category_id)
    {

        $category = Category::where('category_url', $category_id)->first();


        $products = Product::with('category')
        ->where('product_url','!=', $product_id)->where('category_id', $category->id)->inRandomOrder()->limit(4)->get();


        // // dd($category);
        // $products = Product::where('product_url','!=', $product_id)->where('category_id', $category->id)->inRandomOrder()->limit(4)->get();
        
        return ProductApiResource::collection($products)->response()
        ->setStatusCode(200);
    }


    public function show(Product $product)
    {
        return ProductApiResource::make($product)->response()
            ->setStatusCode(200);      

    }





}
