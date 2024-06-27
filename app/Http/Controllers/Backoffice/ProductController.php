<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\UpdateProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Services\Backoffice\ProductService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $service
    ) {}

    public function index(): JsonResponse
    {
        try {
            $products = $this->service->list();

            return response()->json($products, Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('ProductController - index', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when listing the products.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $products = $this->service->create($request->validated());

            return response()->json($products, Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('ProductController - store', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when creating the product.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $product = $this->service->get($id);

            return response()->json($product, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::error('ProductController - show', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when getting the product.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        try {
            $product = $this->service->update($request->validated(), $id);

            return response()->json($product, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::error('ProductController - update', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when updating the product.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);

            return response()->json([
                'message' => 'Product deleted successfully.'
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::error('ProductController - update', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when updating the product.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
