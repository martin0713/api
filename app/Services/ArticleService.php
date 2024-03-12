<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

/**
 * Class ArticleService.
 */
class ArticleService
{
    public function __construct(private ArticleRepository $repo)
    {
    }

    public function all(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $articles = $this->repo->all();
        return ArticleResource::collection($articles);
    }

    public function create(array $validated): Article
    {
        $validated['user_id'] = Auth::id();
        return $this->repo->create($validated);
    }

    public function find(string $id): ArticleResource
    {
        $article = $this->repo->find($id);
        return new ArticleResource($article);
    }

    public function update(array $validated, Article $article): string
    {
        $records = $article->records;
        $records['time']++;
        $validated['records'] = $records;
        $validated['id'] = $article->id;
        $isSucceed = $this->repo->update($validated);
        if ($isSucceed) return 'success';
        else return 'fail';
    }

    public function delete(Article $article): string
    {
        $isSucceed = $this->repo->delete($article);
        if ($isSucceed) return 'success';
        else return 'fail';
    }
}
