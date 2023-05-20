<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index()
    {
        return response()->success(
            $this->productService->index()
        );
    }
}
