<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserConnectionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'sent' => ConnectionResource::collection($this['sent']),
            'received' => ConnectionResource::collection($this['received']),
        ];
    }
}
