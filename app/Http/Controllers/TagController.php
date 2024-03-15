<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TagService;
use App\Http\Requests\TagStoreRequest;
use App\Http\Resources\TagResource;
use App\Http\Resources\EmptyResource;

class TagController extends Controller
{
    public function __construct(private readonly TagService $service)
    {
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->find($id);
        if ($data === null) {
            return (new EmptyResource($data))->response();
        }
        return TagResource::make($data)->response();
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
        if ($result) {
            return response('success');
        }
        return response('fail');
    }

    public function destroy(Request $request): \Illuminate\Http\Response
    {
        $result = $this->service->delete($request->route('id'));
        if ($result) {
            return response('success');
        }
        return response('fail');
    }
}
