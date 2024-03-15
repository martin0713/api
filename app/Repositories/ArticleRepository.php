<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Support\Facades\DB;

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
    public function update(array $validated): void
    {
        DB::transaction(function () use ($validated) {
            $article = $this->model->find($validated['id']);
            $article->update($validated);
            $article->tags()->sync($validated['tags']);
        }, 3);
    }
    /**
     * @param array $validated
     * @return boolean
     */
    public function delete(Article $article): void
    {
        DB::transaction(function () use ($article) {
            $article = $this->model->find($article->id);
            $article->tags()->detach();
            $article->delete();
        }, 3);
    }
}
