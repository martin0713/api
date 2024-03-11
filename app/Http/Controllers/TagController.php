<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TagService;

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
}
