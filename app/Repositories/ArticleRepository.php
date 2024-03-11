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
        return $this->model->with('tags')->get();
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
     * @param string $id
     * @return Article
     */
    public function find(string $id)
    {
        $article = $this->model->find($id);
        return $article;
    }
    /**
     * @param array $validated
     * @return Article
     */
    public function update(array $validated)
    {
        $this->model->find($validated['id'])->update($validated);
        $this->model->find($validated['id'])->tags()->sync($validated['tags']);
    }
    /**
     * @param array $validated
     * @return Article
     */
    public function delete(Article $article)
    {
        return $this->model->find($article->id)->delete();
    }
}
