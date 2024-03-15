<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

/**
 * Class ArticleService.
 */
class ArticleService
{
    public function __construct(private readonly ArticleRepository $repo)
    {
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repo->all();
    }

    public function create(array $validated): Article
    {
        $validated['user_id'] = Auth::id();
        return $this->repo->create($validated);
    }

    public function find(string $id): Article |null
    {
        return $this->repo->find($id);
    }

    public function update(array $validated, Article $article): bool
    {
        $records = $article->records;
        $records['time']++;
        $validated['records'] = $records;
        $validated['id'] = $article->id;
        $this->repo->update($validated);
        return true;
    }

    public function delete(Article $article): bool
    {
        $this->repo->delete($article);
        return true;
    }
}
