<?php

use App\Models\Blog;
use App\Models\User;
use Inertia\Inertia;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Web\BlogController as WebBlogController;
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

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::controller(BlogController::class)->group(function () {

            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

            Route::resource('blog', BlogController::class);
            Route::post('blog/upload', [BlogController::class, 'upload'])->name('blog.upload');
            Route::put('blog/toggle-status/{blog}', [BlogController::class, 'toggleStatus'])->name('blog.toggle.status');
            Route::put('blog/toggle-highlight/{blog}', [BlogController::class, 'toggleHighlight'])->name('blog.toggle.highlight');
        });
    });
});

Route::controller(WebBlogController::class)->group(function () {
    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    })->name('welcome');
    Route::get('{blog}-{slug}', [WebBlogController::class, 'showWithSlug'])->name('blog.show.with.slug');
    Route::get('blog/all', [WebBlogController::class, 'getAllBlogs'])->name('blog.all');
});

