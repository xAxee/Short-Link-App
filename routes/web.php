<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\DiscordController;
use App\Http\Controllers\ApiController;

// Login routes api.*
Route::controller(DiscordController::class)->prefix("api")->group(function() {
    Route::get('login', [DiscordController::class, 'login'])->name('api.login');
    Route::get('callback', [DiscordController::class, 'callback'])->name('api.callback');
    Route::get('logout', [DiscordController::class, 'logout'])->name('api.logout');
});
// Auth links routes link.*
Route::controller([ShortLinkController::class])
->prefix('link')
->middleware(AuthMiddleware::class)
->group(function(){
    Route::get('list', [ShortLinkController::class, 'links'])->name('link.list');
    Route::post('post', [ShortLinkController::class, 'store'])->name('link.post');
    Route::get('post', [ShortLinkController::class, 'store'])->name('index');
    Route::get('delete/{id}', [ShortLinkController::class, 'destroy'])->name('link.delete');
    Route::get('qrcode/{id}', [ShortLinkController::class, 'qrcode'])->name('link.qrcode');
});
// Index & Redirect routes
Route::get('/', [ShortLinkController::class, 'index'])->name('index');
// API routes
Route::prefix('api/v1')->group(function() {
    Route::get('/links', [ApiController::class, 'getLinks']);
    Route::post('/links', [ApiController::class, 'createLink']);
});

Route::get('/api', [ApiController::class, 'docs'])->name('api.docs');

Route::get('/{id}', [ShortLinkController::class, 'show'])->name('get');
