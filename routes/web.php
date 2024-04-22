<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BlogController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/pictureupload', function () {
    return Inertia::render('PictureUpload');
})->middleware(['auth', 'verified'])->name('pictureupload');


Route::resource('blogs', BlogController::class)->middleware(['auth', 'verified']);


Route::post('/blogs/pictures', [BlogController::class, 'storePicture'])->middleware(['auth', 'verified'])->name('pictures.store');

// Route::get('/picture', function () {
//     // get the users pictures to display in the edit form for blogs
//     $pictures = auth()->user()->pictures;
//     return Inertia::render('Picture', [
//         'pictures' => $pictures
//     ]);

// })->middleware(['auth', 'verified']);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
