<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TagService;
use App\Http\Requests\TagStoreRequest;
use App\Http\Resources\TagResource;

class TagController extends Controller
{
    public function __construct(private TagService $service)
    {
    }

    public function show(string $id): \Illuminate\Http\Response
    {
        $data = $this->service->find($id);
        if ($data) return response(new TagResource($data));
        else return response('Not Found', 404);
    }

    public function index(): \Illuminate\Http\Response
    {
        $data = $this->service->all();
        return response(TagResource::collection($data));
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
