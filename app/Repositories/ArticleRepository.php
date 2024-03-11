<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    private $model;
    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->cursor();
    }

    public function create($validated)
    {
        return $this->model->create($validated);
    }

    public function find(string $id)
    {
        $article = $this->model->find($id);
        return $article;
    }

    public function update($validated)
    {
        $this->model->find($validated['id'])->update($validated);
        $this->model->find($validated['id'])->tags()->sync($validated['tags']);
    }

    public function delete($article)
    {
        return $this->model->find($article->id)->delete();
    }
}
