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
        $result = $this->productService->index();

        if (!$result['success']) return response()->error($result['errors']);

        return response()->success($result['data']);
    }

    public function show(Product $product): JsonResponse
    {
        $result = $this->productService->show($product);

        if (!$result['success']) return response()->error($result['errors']);

        return response()->success($result['data']);
    }
}
