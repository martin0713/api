<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{
    private Tag $model;
    public function __construct(Tag $model)
    {
        $this->model = $model;
    }
    /**
     * @param string $id
     * @return Tag
     */
    public function find(string $id): Tag
    {
        return $this->model->find($id);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with('articles')->get();
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
        return $this->model->find($id)->delete();
    }
};
