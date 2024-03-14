<?php

namespace App\Services;

use App\Repositories\TagRepository;
use App\Models\Tag;

class TagService
{
    public function __construct(private readonly TagRepository $repo)
    {
    }

    public function find(string $id): Tag |null
    {
        return $this->repo->find($id);
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repo->all();
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
