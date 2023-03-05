<?php

use App\Models\Blog;
use App\Models\User;
use Inertia\Inertia;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\BlogController;
use Stevebauman\Location\Facades\Location;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('blog', BlogController::class);
    Route::post('blog/upload', [BlogController::class, 'upload'])->name('blog.upload');
    Route::put('blog/toggle-status/{blog}', [BlogController::class, 'toggleStatus'])->name('blog.toggle.status');
});
Route::get('{blog}-{slug}', [BlogController::class, 'showWithSlug'])->name('blog.show.with.slug');
Route::get('blogs/all', [BlogController::class, 'getAllBlogs'])->name('blogs');
