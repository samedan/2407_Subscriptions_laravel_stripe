<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::get('/subscription-checkout', function (Request $request) {
    return $request->user()
        ->newSubscription('prod_QRBEaK0UrHuBnW', 'price_1PaIrZEJfmkQtLYrigHrIFu7')
        ->trialDays(5)
        ->allowPromotionCodes()
        ->checkout([
            'success_url' => route('success'),
            'cancel_url' => route('dashboard'),
        ]);
});


// Success
Route::get('/success', function () {
    return view('success');
})->middleware(['auth', 'verified'])->name('success');


require __DIR__.'/auth.php';
