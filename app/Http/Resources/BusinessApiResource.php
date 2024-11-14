<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\JsonResponse;


class BusinessApiResource extends JsonResource
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
            'email' => $this->email,
            'phone_1'=> $this->phone_one,
            'phone_2'=>$this->phone_two,
            'whatsapp'=>$this->whatsapp,
            'gst_number' => $this->gst_number,
            'address'=>$this->address,
            'location'=>$this->map,
            'business_time'=>$this->open_hours

        ];
    }


    public function withResponse(Request $request, JsonResponse $response): void
    {
        $response->header('X-Value', 'True');
    }
}
