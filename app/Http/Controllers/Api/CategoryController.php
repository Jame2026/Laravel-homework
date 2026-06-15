<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::orderByDesc('id')->get();

        return response()->json($categories);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dec' => ['required', 'string'],
        ]);

        $category = Category::create($data);

        return response()->json($category, 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json(Category::findOrFail($id));
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'dec' => ['sometimes', 'string'],
        ]);

        $category->update($data);
        $category->refresh();

        return response()->json($category);
    }

    public function destroy(string $id): JsonResponse
    {
        Category::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
