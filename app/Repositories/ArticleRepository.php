<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    public function __construct(private readonly Article $model)
    {
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with(['user', 'tags'])->get();
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
    public function find(string $id): Article |null
    {
        return $this->model->with(['user', 'tags'])->find($id);
    }
    /**
     * @param array $validated
     * @return boolean
     */
    public function update(array $validated): bool
    {
        $article = $this->model->find($validated['id']);
        $result1 = $article->update($validated);
        $result2 = $article->tags()->sync($validated['tags']);
        return $result1 && $result2;
    }
    /**
     * @param array $validated
     * @return boolean
     */
    public function delete(Article $article): bool
    {
        $article = $this->model->find($article->id);
        $result1 = $article->tags()->detach();
        $result2 = $article->delete();
        return $result1 && $result2;
    }
}
