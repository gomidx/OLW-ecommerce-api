<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function list(): LengthAwarePaginator
    {
        return Category::paginate();
    }

    public function create(array $data): ?Category
    {
        return Category::create($data);
    }

    public function get(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function update(array $data, int $id): Category
    {
        $category = $this->get($id);

        $category->update($data);

        return $category;
    }

    public function delete(int $id): void
    {
        $category = $this->get($id);

        $category->delete();
    }
}
