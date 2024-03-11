<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{
    private $model;
    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    public function find(string $id)
    {
        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->with('articles')->get();
    }

    public function create(array $validated)
    {
        return $this->model->create($validated);
    }

    public function update(array $validated)
    {
        return $this->model->find($validated['id'])->update($validated);
    }

    public function delete(string $id)
    {
        return $this->model->find($id)->delete();
    }
};
