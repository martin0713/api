<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    public function __construct(private Article $model)
    {
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with('tags')->get();
    }
    /**
     * @param array $validated
     * @return Article
     */
    public function create(array $validated): Article
    {
        return $this->model->create($validated);
    }
    /**
     * @param string $id
     * @return Article
     */
    public function find(string $id): Article
    {
        $article = $this->model->find($id);
        return $article;
    }
    /**
     * @param array $validated
     * @return boolean
     */
    public function update(array $validated): bool
    {
        $result1 = $this->model->find($validated['id'])->update($validated);
        $result2 = $this->model->find($validated['id'])->tags()->sync($validated['tags']);
        return $result1 && $result2;
    }
    /**
     * @param array $validated
     * @return boolean
     */
    public function delete(Article $article): bool
    {
        return $this->model->find($article->id)->delete();
    }
}
