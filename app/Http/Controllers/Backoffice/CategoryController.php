<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Backoffice\CategoryService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $service
    ) {}

    public function index()
    {
        Gate::authorize('viewAny', Category::class);

        try {
            $categories = $this->service->list();

            return response()->json($categories, Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('CategoryController - index', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when listing the categories.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        Gate::authorize('create', Category::class);

        try {
            $category = $this->service->create($request->validated());

            return response()->json($category, Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error('CategoryController - store', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when creating the category.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id)
    {
        Gate::authorize('view', Category::class);

        try {
            $category = $this->service->get($id);

            return response()->json($category, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::error('CategoryController - show', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when getting the category.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateCategoryRequest $request, int $id)
    {
        Gate::authorize('update', Category::class);

        try {
            $category = $this->service->update($request->validated(), $id);

            return response()->json($category, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::error('CategoryController - update', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when updating the category.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id)
    {
        Gate::authorize('delete', Category::class);

        try {
            $this->service->delete($id);

            return response()->json([
                'message' => 'Category successfully deleted!'
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::error('CategoryController - update', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when updating the category.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
