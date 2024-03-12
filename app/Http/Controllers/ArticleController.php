<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Services\ArticleService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\EmptyResource;

class ArticleController extends Controller
{
    public function __construct(private readonly ArticleService $service)
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $data = $this->service->all();
        return ArticleResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ArticleStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleStoreRequest $request): \Illuminate\Http\Response
    {
        $validated = $request->validated();
        $data = $this->service->create($validated);
        return response($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->find($id);
        if ($data === null) {
            return (new EmptyResource($data))->response();
        }
        return ArticleResource::make($data)->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ArticleUpdateRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ArticleUpdateRequest $request, Article $article): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        if ($user->cant('update', $article)) {
            return response()->json(['message' => 'You don\'t have permission to update']);
        }
        $validated = $request->validated();
        $result = $this->service->update($validated, $article);
        return response()->json(['message' => $result]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Article $article): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();
        if ($user->cant('delete', $article)) {
            return response()->json(['message' => 'You don\'t have permission to delete']);
        }
        $this->service->delete($article);
        return redirect(route('articles.index'));
    }
}
