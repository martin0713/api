<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TagService;
use App\Http\Requests\TagStoreRequest;

class TagController extends Controller
{
    private $service;
    public function __construct(TagService $tagService) {
        $this->service = $tagService;
    }

    public function show(string $id) {
        return $this->service->find($id);
    }

    public function index() {
        return $this->service->all();
    }

    public function store(TagStoreRequest $request) {
        $validated = $request->validated();
        return $this->service->create($validated);
    }

    public function update(TagStoreRequest $request) {
        $validated = $request->validated();
        $validated['id'] = $request->route('id');
        return $this->service->update($validated);
    }

    public function destroy(Request $request) {
        $this->service->delete($request->route('id'));
        return redirect('/api/tags');
    }
}
