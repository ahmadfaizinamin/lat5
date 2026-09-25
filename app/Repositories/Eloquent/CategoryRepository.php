<?php
namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Override;

class CategoryRepository implements CategoryRepositoryInterface
{
    #[Override]
    public function getAll()
    {
        return Category::all();
    }
    
    #[Override]
    public function getById($id)
    {
        return Category::findOrFail($id);
    }

    #[Override]
    public function create(array $data)
    {
        return Category::create($data);
    }

    #[Override]
    public function update($id, array $data)
    {
        $category = $this->getById($id);
        $category->update($data);

        return $category;
    }

    #[Override]
    public function delete($id)
    {
        $category = $this->getById($id);
        return $category->delete();
    }
}