<?php

namespace App\Services\Backoffice;

use App\Models\Brand;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandService
{
    public function list(): LengthAwarePaginator
    {
        return Brand::paginate();
    }

    public function create(array $data): ?Brand
    {
        return Brand::create($data);
    }

    public function get(int $id): Brand
    {
        return Brand::findOrFail($id);
    }

    public function update(array $data, int $id): Brand
    {
        $brand = $this->get($id);

        $brand->update($data);

        return $brand;
    }

    public function delete(int $id): void
    {
        $brand = $this->get($id);

        $brand->delete();
    }
}
