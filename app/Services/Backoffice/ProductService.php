<?php

namespace App\Services\Backoffice;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function list(): LengthAwarePaginator
    {
        return Product::paginate();
    }

    public function create(array $data): ?Product
    {
        return Product::create($data);
    }

    public function get(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function update(array $data, int $id): Product
    {
        $product = $this->get($id);

        $product->update($data);

        return $product;
    }

    public function delete(int $id): void
    {
        $product = $this->get($id);

        $product->delete();
    }
}
