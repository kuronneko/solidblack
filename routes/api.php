<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogController as WebBlogController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {
    Route::controller(WebBlogController::class)
        ->as('blogs.')
        ->prefix('blogs')
        ->group(function () {
            Route::get('/', 'index')->name('index');
   /*          Route::get('/{blog}/{category}', 'show')->name('show'); */
        });
});
