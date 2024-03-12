<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmptyResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this::withoutWrapping();
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'message' => 'Not found',
        ];
    }

    public function withResponse($request, $response): void
    {
        $response->setStatusCode(404);
    }
}
