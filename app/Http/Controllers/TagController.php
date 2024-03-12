<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TagService;
use App\Http\Requests\TagStoreRequest;

class TagController extends Controller
{
    private TagService $service;
    public function __construct(TagService $tagService)
    {
        $this->service = $tagService;
    }

    public function show(string $id): \Illuminate\Http\Response
    {
        $data = $this->service->find($id);
        return response($data);
    }

    public function index(): \Illuminate\Http\Response
    {
        $data = $this->service->all();
        return response($data);
    }

    public function store(TagStoreRequest $request): \Illuminate\Http\Response
    {
        $validated = $request->validated();
        $data = $this->service->create($validated);
        return response($data);
    }

    public function update(TagStoreRequest $request): \Illuminate\Http\Response
    {
        $validated = $request->validated();
        $validated['id'] = $request->route('id');
        $result = $this->service->update($validated);
        return response($result);
    }

    public function destroy(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->service->delete($request->route('id'));
        return redirect('/api/tags');
    }
}
