<?php

namespace App\Http\Services;

use App\Http\Resources\ProductCollection;
use App\Models\Product;

class ProductService {
    public function index(): ProductCollection
    {
        return new  ProductCollection(Product::all());
    }
}
