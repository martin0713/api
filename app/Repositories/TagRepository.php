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
        return $this->model->cursor();
    }

    public function create($validated)
    {
        return $this->model->create($validated);
    }

    public function update($validated)
    {
        return $this->model->find($validated['id'])->update($validated);
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }
};
