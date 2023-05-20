<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($data, $statusCode = 200, $message = 'Success.') {
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => $message
            ], $statusCode);
        });

        Response::macro('error', function ($errors, $statusCode = 400, $message = 'Error!') {
            return response()->json([
                'success' => false,
                'errors' => $errors,
                'message' => $message
            ], $statusCode);
        });
    }
}
