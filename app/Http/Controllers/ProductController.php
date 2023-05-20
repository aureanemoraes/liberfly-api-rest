<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index(): JsonResponse
    {
        return response()->success(
            $this->productService->index()
        );
    }

    public function show(Product $product): JsonResponse
    {
        return response()->success(
            $this->productService->show($product)
        );
    }
}
