<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NameController;


Route::get('/blade', [NameController::class, 'index'])->name('name.index');
Route::post('/blade/store', [NameController::class, 'store'])->name('name.store');
Route::get('/blade/show/{id}', [NameController::class, 'show'])->name('name.show');
Route::get('/blade/edit/{id}', [NameController::class, 'edit'])->name('name.edit');
Route::put('/blade/update/{id}', [NameController::class, 'update'])->name('name.update');


Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
