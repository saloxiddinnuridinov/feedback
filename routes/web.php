<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/clear-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
//    \Illuminate\Support\Facades\Artisan::call('filament:clear-cached-components');
//    \Illuminate\Support\Facades\Artisan::call('filament:assets');
    \Illuminate\Support\Facades\Artisan::call('optimize');

    return "Kesh muvaffaqiyatli tozalandi!";
});
Route::get('/', function () {
    if(\Illuminate\Support\Facades\Auth::check()){
        return redirect()->route("dashboard");
    }
    return view('admin.login');
})->name('login');
Route::post('/sign-in', [\App\Http\Controllers\AdminController::class, 'login'])->name('sign');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('users', App\Http\Controllers\UserController::class);

    Route::get('/admin/messages', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.messages.index');
    Route::get('/admin/answers', [\App\Http\Controllers\AdminController::class, 'getAnswers'])->name('admin.messages.answers');
    Route::get('/admin/answer/{message_id}', [\App\Http\Controllers\AdminController::class, 'show'])->name('admin.answer');
    Route::post('/admin/messages/{id}/reply', [\App\Http\Controllers\AdminController::class, 'reply'])->name('admin.messages.reply');
    Route::get('logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        return redirect()->route("login");
    })->name("logout");

    Route::get('/admin/get-message/{id}', [\App\Http\Controllers\AdminController::class, 'getPerson'])->name('get.Person');

});

Route::post('telegramBot', [\App\Http\Controllers\TelegramBotController::class, 'handle'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);;

Route::get('/webhook', function () {
    return file_get_contents("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/setwebhook?url=" . env('WEBHOOK_URL') . "/telegramBot");
});
