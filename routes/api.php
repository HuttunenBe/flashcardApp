<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NameColorController;
use App\Http\Controllers\Api\WordController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

Route::apiResource('name-colors', NameColorController::class);

// Words routes
Route::get('/words', function () {
    $response = Http::withHeaders([
        'x-api-key' => env('FINNFAST_API_KEY'),
        'accept' => 'application/json',
    ])->get('https://finnfast.fi/api/words');

    return response()->json($response->json(), $response->status());
});


Route::get('/words/favorites', [WordController::class, 'favorites'])->name('words.favorites');
Route::post('/words/{apiId}/favorite', [WordController::class, 'toggleFavorite'])->name('words.toggleFavorite');
Route::delete('/words/{apiId}', [WordController::class, 'destroy'])->name('words.destroy');

