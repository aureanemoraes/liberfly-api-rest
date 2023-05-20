<?php

namespace App\Http\Services;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductService {
    public function index(): ProductCollection
    {
        return new ProductCollection(Product::all());
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }
}
