<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ArticleUserResource;
use App\Http\Resources\ArticleTagResource;

class ArticleResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->image,
            'records' => $this->records,
            'tag' => ArticleTagResource::collection($this->whenLoaded('tags')),
            'user' => new ArticleUserResource($this->whenLoaded('user')),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
