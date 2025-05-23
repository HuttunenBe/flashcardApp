<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NameColorController;
use App\Http\Controllers\Api\WordController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

Route::apiResource('name-colors', NameColorController::class);

Route::apiResource('words', WordController::class);


Route::get('/words', function () {
    $response = Http::withHeaders([
        'x-api-key' => env('FINNFAST_API_KEY'),
        'accept' => 'application/json',
    ])->get('https://finnfast.fi/api/words');

    return response()->json($response->json(), $response->status());
});


Route::get(
    uri: '/user',
    action: function (Request $request) {
        return $request->user();
    }
)->middleware('auth:sanctum');


Route::post('/words/{ApiId}/favorite', [WordController::class, 'words'])->name('words.index');
