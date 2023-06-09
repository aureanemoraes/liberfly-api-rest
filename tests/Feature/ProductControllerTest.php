<?php


// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     */

    public function test_index(): void
    {
        // registering user
        $email = fake()->unique()->safeEmail();
        $password = Str::random('10');

        $registerResponse = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('auth.register'), [
            'name' => fake()->name,
            'email' => $email,
            'password' => $password
        ]);

        $registerResponse->assertStatus(201);

        // logging user
        $userResponse = $this->post(route('auth.login'), [
            'email' => $email,
            'password' => $password
        ]);

        $userResponse->assertStatus(200);

        [ 'data' => $data ] = $userResponse->json();

        // testing index
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $data['authorization']['type'] . ' ' . $data['authorization']['token']
        ])->get(route('products.index'));

        $response->assertStatus(200);
    }

    public function test_show(): void
    {
        // registering user
        $email = fake()->unique()->safeEmail();
        $password = Str::random('10');

        $registerResponse = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('auth.register'), [
            'name' => fake()->name,
            'email' => $email,
            'password' => $password
        ]);

        $registerResponse->assertStatus(201);

        // logging user
        $userResponse = $this->post(route('auth.login'), [
            'email' => $email,
            'password' => $password
        ]);

        $userResponse->assertStatus(200);

        [ 'data' => $data ] = $userResponse->json();

        // testing show
        $product = Product::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $data['authorization']['type'] . ' ' . $data['authorization']['token']
        ])->get(route('products.show', $product));

        $response->assertStatus(200);
    }


    public function test_index_without_jwt_token(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get(route('products.index'));

        $response->assertStatus(401);
    }

    public function test_show_without_jwt_token(): void
    {
        $product = Product::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get(route('products.show', $product));

        $response->assertStatus(401);
    }
}
