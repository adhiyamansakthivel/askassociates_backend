<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\JsonResponse;


class ClientApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $salt = "adhiinc_askassociates_4203840234564";


        return [
            'id' => sha1($this->id.$salt),
            'name' =>$this->name,
            'logo' => asset('storage/' . $this->logo),
        ];
    }


    public function withResponse(Request $request, JsonResponse $response): void
    {
        $response->header('X-Value', 'True');
    }
}
