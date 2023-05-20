<?php


// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     */

    public function test_index_without_jwt_token(): void
    {
        $response = $this->get(route('products.index'));

        $response->assertStatus(401);
    }

    public function test_show_without_jwt_token(): void
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(401);
    }
}
