<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Models\Brand;
use App\Services\BrandService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    public function __construct(
        protected BrandService $service
    ) {}

    public function index()
    {
        Gate::authorize('viewAny', Brand::class);

        try {
            $brands = $this->service->list();

            return response()->json($brands, Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('BrandController - index', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when listing the brands.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreBrandRequest $request)
    {
        Gate::authorize('create', Brand::class);

        try {
            $brand = $this->service->create($request->validated());

            return response()->json($brand, Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error('BrandController - store', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when creating the brand.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id)
    {
        Gate::authorize('view', Brand::class);

        try {
            $brand = $this->service->get($id);

            return response()->json($brand, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Brand not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::error('BrandController - show', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when getting the brand.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateBrandRequest $request, int $id)
    {
        Gate::authorize('update', Brand::class);

        try {
            $brand = $this->service->update($request->validated(), $id);

            return response()->json($brand, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Brand not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::error('BrandController - update', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when updating the brand.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id)
    {
        Gate::authorize('delete', Brand::class);

        try {
            $this->service->delete($id);

            return response()->json([
                'message' => 'Brand successfully deleted!'
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Brand not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::error('BrandController - update', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred when updating the brand.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
