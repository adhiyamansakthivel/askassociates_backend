<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\JsonResponse;


class CategoryApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $salt = "adhiinc_askassociates_42038402384";


        return [
            'id' => sha1($this->id.$salt),
            'name' =>$this->name,
            'slug_url' => $this->category_url,
            'products' => ProductApiResource::collection($this->whenLoaded('products')),
            'products_count' => $this->whenCounted('products'),
            'meta_keword'=> $this->meta_keyword,

        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        $response->header('X-Value', 'True');
    }
}
