<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductService
{
    protected ProductRepositoryInterface $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getAllProduct()
    {
        return Cache::remember('products_all', 60, function () {
            Log::info('[CACHE] mengambil data dari DB');

            return $this->productRepo->getAll()->toArray();
        });
    }

    public function getByIdProduct(string $id)
    {
        return Cache::remember("product_{$id}", 60, function () use ($id) {
            Log::info('[CACHE] mengambil data dari DB');

            return $this->productRepo->getById($id);
        });
    }

    public function createProduct(array $data)
    {
        Cache::forget('products_all');
        Log::info('[CACHE] hapus semua cache (Create Product)');

        return $this->productRepo->create($data);
    }

    public function updateProduct(string $id, array $data)
    {
        Cache::forget('products_all');
        Cache::forget("product_{$id}");
        Log::info('[CACHE] hapus semua cache (Update Product)');

        return $this->productRepo->update($id, $data);
    }

    public function deleteProduct(string $id)
    {
        Cache::forget('products_all');
        Cache::forget("product_{$id}");
        Log::info('[CACHE] hapus semua cache (Delete Product)');

        return $this->productRepo->delete($id);
    }
}
