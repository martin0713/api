<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{
    public function __construct(private readonly Tag $model)
    {
    }
    /**
     * @param string $id
     * @return Tag
     */
    public function find(string $id): Tag |null
    {
        return $this->model->with('articles.user')->find($id);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with('articles.user')->get();
    }
    /**
     * @param array $validated
     * @return Tag
     */
    public function create(array $validated): Tag
    {
        return $this->model->create($validated);
    }
    /**
     * @param array $validated
     * @return boolean
     */
    public function update(array $validated): bool
    {
        return $this->model->find($validated['id'])->update($validated);
    }
    /**
     * @param string $id
     * @return boolean
     */
    public function delete(string $id): bool
    {
        $tag = $this->model->find($id);
        $result1 = $tag->articles()->detach();
        $result2 = $tag->delete();
        return $result1 && $result2;
    }
};
