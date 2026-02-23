<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ContactController::class, 'index']);
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/thanks', [ContactController::class, 'store']);
Route::get('/thanks', [ContactController::class, 'thanks']);

Route::middleware('auth')->group(function () {
    Route::get('/admin', [ContactController::class, 'admin']);
    Route::get('/search', [ContactController::class, 'search']);
    Route::get('/reset', function () {
        return redirect('/admin');
    });
    Route::get('/export', [ContactController::class, 'export']);
    Route::delete('/delete/{contact}', [ContactController::class, 'destroy']);
});
