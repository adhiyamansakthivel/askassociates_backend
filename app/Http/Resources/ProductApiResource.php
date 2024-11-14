<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $salt = "adhiinc_askassociates_42038402384";

        // $product_images  = 

        // $this->product_images->map(function ($val, $key)  {
        //     return asset('storage/' .  $this->$val);
        //  });

        $productImage = array();
        foreach ($this->product_images as $images) {

            $productImage[] =(object) [ "productImage" => asset('storage/'.$images)];
        }

        return [
            'id' => sha1($this->id.$salt), 
            'title' =>$this->title,
            'slug_url' => $this->product_url,
            'description'=>$this->description,
            'images' =>   $productImage,
            'price' => round($this->price),
            'per' => $this->price_per,
            'availablity' => $this->status,
            'brand' => new BrandApiResource($this->brand),
            'category'=> new CategoryApiResource($this->category),
            'subcategory' => new SubCategoryApiResource($this->subcategory),
            'meta_keword'=> $this->meta_keyword,
            'tags' => $this->tags
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        $response->header('X-Value', 'True');
    }
}
