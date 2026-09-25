<?php
namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Override;

class ProductRepository implements ProductRepositoryInterface
{
    #[Override]
    public function getAll()
    {
        return Product::with('category')->get();
    }
    
    #[Override]
    public function getById($id)
    {
        return Product::findOrFail($id);
    }

    #[Override]
    public function create(array $data)
    {
        return Product::create($data);
    }

    #[Override]
    public function update($id, array $data)
    {
        $product = $this->getById($id);
        $product->update($data);

        return $product;
    }

    #[Override]
    public function delete($id)
    {
        $product = $this->getById($id);
        return $product->delete();
    }
}