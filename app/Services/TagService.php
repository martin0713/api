<?php

namespace App\Services;

use App\Repositories\TagRepository;
use App\Http\Resources\TagResource;
use App\Models\Tag;

class TagService
{
    public function __construct(private TagRepository $repo)
    {
    }

    public function find(string $id): TagResource
    {
        $tag = $this->repo->find($id);
        return new TagResource($tag);
    }

    public function all(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $tags = $this->repo->all();
        return TagResource::collection($tags);
    }

    public function create(array $validated): Tag
    {
        return $this->repo->create($validated);
    }

    public function update(array $validated): string
    {
        $result = $this->repo->update($validated);
        if ($result) return 'success';
        else return 'fail';
    }

    public function delete(string $id): string
    {
        $result = $this->repo->delete($id);
        if ($result) return 'success';
        else return 'fail';
    }
}
