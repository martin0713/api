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
    /**
     * @param string $id
     * @return Tag
     */
    public function find(string $id)
    {
        return $this->model->find($id);
    }
    /**
     * @return Tag
     */
    public function all()
    {
        return $this->model->with('articles')->get();
    }
    /**
     * @param array $validated
     * @return Article
     */
    public function create(array $validated)
    {
        return $this->model->create($validated);
    }
    /**
     * @param array $validated
     * @return Article
     */
    public function update(array $validated)
    {
        return $this->model->find($validated['id'])->update($validated);
    }
    /**
     * @param string $id
     * @return Tag
     */
    public function delete(string $id)
    {
        return $this->model->find($id)->delete();
    }
};
