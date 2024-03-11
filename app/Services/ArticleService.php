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
    private $repo;
    public function __construct(ArticleRepository $repo)
    {
        $this->repo = $repo;
    }

    public function all()
    {
        $articles = $this->repo->all();
        return ArticleResource::collection($articles);
    }

    public function create(array $validated)
    {
        $validated['user_id'] = Auth::id();
        return $this->repo->create($validated);
    }

    public function find(string $id)
    {
        $article = $this->repo->find($id);
        return new ArticleResource($article);
    }

    public function update(array $validated, Article $article)
    {
        $records = $article->records;
        $records['time']++;
        $validated['records'] = $records;
        $validated['id'] = $article->id;
        $this->repo->update($validated);
        return $validated;
    }

    public function delete(Article $article)
    {
        $this->repo->delete($article);
    }
}
