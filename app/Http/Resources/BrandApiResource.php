<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandApiResource extends JsonResource
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
            'logo' =>asset('storage/' . $this->logo),
            'name' =>$this->name,
            'slug_url' => $this->brand_url,
           
        ];
    }


    public function withResponse(Request $request, JsonResponse $response): void
    {
        $response->header('X-Value', 'True');
    }
}
