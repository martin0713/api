<?php

namespace App\Services;

use App\Repositories\TagRepository;
use App\Http\Resources\TagResource;

class TagService{
    private $repo;
    public function __construct(TagRepository $repo) {
        $this->repo = $repo;
    }

    public function find(string $id) {
        $tag = $this->repo->find($id);
        $tag->articles;
        return new TagResource($tag);
    }

    public function all() {
        $tags = $this->repo->all();
        foreach ($tags as $tag) {
            $tag->articles;
        }
        return TagResource::collection($tags);
    }
};
