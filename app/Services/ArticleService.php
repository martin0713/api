<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\ArticleRepository;

/**
 * Class ArticleService.
 */
class ArticleService
{
    private $repo;
    public function __construct(ArticleRepository $repo) {
        $this->repo = $repo;
    }

    public function all() {
        return $this->repo->all();
    }

    public function create($validated) {
        return $this->repo->create($validated);
    }

    public function find(string $id) {
        return $this->repo->find($id);
    }

    public function update($validated, $article) {
        $records = $article->records;
        $records['time']++;
        $validated['records'] = $records;
        $validated['id'] = $article->id;
        $this->repo->update($validated);
        return $validated;
    }

    public function delete($article) {
        $this->repo->delete($article);
    }
}