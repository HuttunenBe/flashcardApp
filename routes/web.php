<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NameController;


Route::get('/blade', [NameController::class, 'index'])->name('words.index');
Route::post('/blade/store', [NameController::class, 'store'])->name('words.store');
Route::get('/blade/show/{id}', [NameController::class, 'show'])->name('words.show');
Route::put('/blade/update/{id}', [NameController::class, 'update'])->name('words.update');


Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
