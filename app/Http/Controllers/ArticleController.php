<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Services\ArticleService;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    private $service;
    public function __construct(ArticleService $articleService)
    {
        $this->service = $articleService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleStoreRequest $request)
    {
        $validated = $request->validated();
        $this->service->create($validated);
        return $validated;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        return $this->service->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleUpdateRequest $request, Article $article)
    {
        $user = Auth::user();
        if ($user->cant('update', $article)) {
            return response()->json(['message' => 'You don\'t have permission to update']);
        }
        $validated = $request->validated();
        return $this->service->update($validated, $article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->service->delete($article);
        return redirect(route('articles.index'));
    }
}
