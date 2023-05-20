<?php


// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     */

    public function test_register(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post(route('auth.register'), [
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail(),
            'password' => Str::random('10')
        ]);

        $response->assertStatus(201);
    }

    public function test_login(): void
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
        $response = $this->post(route('auth.login'), [
            'email' => $email,
            'password' => $password
        ]);

        $response->assertStatus(200);
    }

    public function test_logout(): void
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
        $response = $this->post(route('auth.login'), [
            'email' => $email,
            'password' => $password
        ]);

        $response->assertStatus(200);

        // logging out user
        $response = $this->post(route('auth.logout'));

        $response->assertStatus(200);
    }

    public function test_refresh(): void
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
        $response = $this->post(route('auth.login'), [
            'email' => $email,
            'password' => $password
        ]);

        $response->assertStatus(200);

        // refreshing token
        $response = $this->post(route('auth.refresh'));

        $response->assertStatus(200);
    }

}
