<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->fail(
                developerMessage: 'No autenticado.',
                userMessage: 'No autenticado.',
                httpCode: 401
            );
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exc)
    {
        if ($exc instanceof ModelNotFoundException) {
            return response()->fail(
                developerMessage: "Recurso no encontrado: {$exc->getMessage()}",
                userMessage: 'Hubo un problema al obtener la información. Inténtalo más tarde.',
                httpCode: 404
            );
        }

        if ($exc instanceof ValidationException) {
            // If it's an Inertia request, let Inertia handle it
            if ($request->header('X-Inertia')) {
                return parent::render($request, $exc);
            }

            // For API requests, use your custom response format
            $errors = $exc->validator->errors()->getMessages();
            return response()->error(
                data: $errors,
                developerMessage: 'Validation Error',
                userMessage: 'Debes completar correctamente los campos del formulario.',
                httpCode: 422
            );
        }

        return parent::render($request, $exc);
    }
}
