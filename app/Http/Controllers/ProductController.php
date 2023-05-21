<?php




namespace App\Http\Controllers;
use OpenApi\Annotations as OA;
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

    /**
    * @OA\SecurityScheme(
    *     type="http",
    *     scheme="bearer",
    *     bearerFormat="JWT",
    *     securityScheme="bearerAuth"
    * )
    *
    * @OA\Get(
    *     path="/api/products",
    *     summary="List all products",
    *     tags={"Products"},
    *     @OA\Response(
    *         response="200",
    *         description="Successful operation",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean"),
    *             @OA\Property(property="data", type="object"),
    *             @OA\Property(property="message", type="string"),
    *         )
    *     ),
    *     security={{ "bearerAuth": {} }},
    *     @OA\Header(
    *         header="Accept",
    *         description="Accept header",
    *         required=true,
    *         @OA\Schema(
    *             type="string",
    *             enum={"application/json"},
    *             default="application/json"
    *         )
    *     ),
    * )
    */
    public function index(): JsonResponse
    {
        $result = $this->productService->index();

        if (!$result['success']) return response()->error($result['errors']);

        return response()->success($result['data']);
    }

    /**
    * @OA\Get(
    *     path="/api/products/{id}",
    *     summary="Get product by id",
    *     tags={"Products"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Product ID",
    *         @OA\Schema(
    *             type="string",
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Successful operation",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean"),
    *             @OA\Property(property="data", type="object"),
    *             @OA\Property(property="message", type="string"),
    *         )
    *     ),
    *     @OA\Response(
    *         response="404",
    *         description="Not Found",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean"),
    *             @OA\Property(property="errors", type="object"),
    *             @OA\Property(property="message", type="string"),
    *         )
    *     ),
    *     security={{ "bearerAuth": {} }},
    *     @OA\Header(
    *         header="Accept",
    *         description="Accept header",
    *         required=true,
    *         @OA\Schema(
    *             type="string",
    *             enum={"application/json"},
    *             default="application/json"
    *         )
    *     ),
    * )
    */
    public function show(Product $product): JsonResponse
    {
        $result = $this->productService->show($product);

        if (!$result['success']) return response()->error($result['errors']);

        return response()->success($result['data']);
    }
}
