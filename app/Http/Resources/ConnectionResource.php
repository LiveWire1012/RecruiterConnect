<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConnectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request

     */
    public function toArray($request)
    {
        return [
            'name' => $this->whenLoaded('connectionUser') ? $this->connectionUser->name : '',
            'mutual_connections' => $this->mutual_connections,
        ];
    }
}
