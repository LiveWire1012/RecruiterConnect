<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConnectionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'name' => $this->relationLoaded('connectionUser') ? $this->connectionUser->name : $this->user->name,
            'mutual_connections' => $this->mutual_connections,
        ];
    }
}
