<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Response::macro('success', function ($data = null, $developerMessage = null, $userMessage = null, $httpCode = 200) {
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'developer_message' => $developerMessage,
                'user_message' => $userMessage,
            ], $httpCode);
        });

        Response::macro('fail', function ($data = null, $developerMessage = null, $userMessage = null, $httpCode = 400) {
            return response()->json([
                'status' => 'fail',
                'data' => $data,
                'developer_message' => $developerMessage,
                'user_message' => $userMessage,
            ], $httpCode);
        });

        Response::macro('error', function ($data = null, $developerMessage = null, $userMessage = null, $httpCode = 500) {
            return response()->json([
                'status' => 'error',
                'errors' => $data,
                'developer_message' => $developerMessage,
                'user_message' => $userMessage,
            ], $httpCode);
        });
    }
}
