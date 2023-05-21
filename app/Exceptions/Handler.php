<?php

namespace App\Exceptions;

use HttpResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // ModelNotFoundException
        $this->renderable(function (ValidationException $e, $request): JsonResponse {
            return response()->error($e->errors(), 422, 'Unprocessable Content.');
        });

        $this->renderable(function (NotFoundHttpException $e, $request): JsonResponse {
            return response()->error(array('No query result.'), 422, 'Not found.');
        });
    }
}
