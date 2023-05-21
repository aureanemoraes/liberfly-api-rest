<?php

namespace App\Http\Services;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductService extends BaseService {
    public function index(): array
    {
        return $this->success(new ProductCollection(Product::all()));
    }

    public function show(Product $product): array
    {
        if (!isset($product))
            return $this->error(['la']);

        return $this->success(new ProductResource($product));
    }
}
