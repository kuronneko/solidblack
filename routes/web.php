<?php

use App\Http\Controllers\GraphController;
use App\Http\Controllers\LoggerController;
use App\Http\Controllers\RedirectShortUrl;
use App\Http\Controllers\SettingController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Jenssegers\Agent\Facades\Agent;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Request;

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
    if(env('APP_ENV') == 'local'){
        $ip = '200.86.155.87';
    }else if(env('APP_ENV') == 'production'){
        $ip = getenv('HTTP_CLIENT_IP')?:
        getenv('HTTP_X_FORWARDED_FOR')?:
        getenv('HTTP_X_FORWARDED')?:
        getenv('HTTP_FORWARDED_FOR')?:
        getenv('HTTP_FORWARDED')?:
        getenv('REMOTE_ADDR');
    }
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'date' => now(),
        'userAgent' => Request::header('user-agent'),
        'location' =>  Location::get($ip),
        'browser' => Agent::browser(),
        'browserVersion' => Agent::version(Agent::browser()),
        'platform' => Agent::platform(),
        'platformVersion' => Agent::version(Agent::platform()),
        'host' => gethostbyaddr($ip),
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', ])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', ['user'=> User::where('id', Auth::user()->id)->with(['setting', 'loggers'])->first() ]);
    })->name('dashboard');
    //Route::get('/dashboard', [LoggerController::class, 'index'])->name('dashboard');
    Route::resource('logger', LoggerController::class);
    Route::delete('/delete-all-logs', [LoggerController::class, 'deleteAllLogs'])->name('delete_all_logs');

    Route::put('/setting/generate-slug/{user}', [SettingController::class, 'generateSlug'])->name('setting_generate_slug');
    Route::put('/setting/silence-mode/{user}', [SettingController::class, 'silenceToggle'])->name('setting_silence_mode');
    Route::put('/setting/save-redirect', [SettingController::class, 'saveRedirect'])->name('setting_save_redirect');

    Route::get('/loggers/export/', [LoggerController::class, 'export'])->name('export');
    Route::post('/loggers/import/', [LoggerController::class, 'import'])->name('import');

    Route::resource('graph', GraphController::class);
    Route::get('/graph/get/total/{date}/{type}', [GraphController::class, 'getTotal'])->name('graph.get.total');
/*     Route::get('/graph/get/country/total/', [GraphController::class, 'getCountryTotal'])->name('graph.get.country.total');
    Route::get('/graph/get/platform/total/', [GraphController::class, 'getPlatformTotal'])->name('graph.get.platform.total');
    Route::get('/graph/get/browser/total/', [GraphController::class, 'getBrowserTotal'])->name('graph.get.browser.total'); */
});

Route::get('{setting:slug}', RedirectShortUrl::class)->name('redirect_short_url');

