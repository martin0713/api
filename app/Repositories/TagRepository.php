<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;

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
    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            $tag = $this->model->find($id);
            $tag->articles()->detach();
            $tag->delete();
        });
    }
};
