<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
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

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    // Home and posts view
    Route::get('/', [PostController::class, 'index'])->name('home');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

    // Comments for posts
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
});
// Authentication routes by Breeze are registered already

// Admin routes group
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::resource('posts', AdminPostController::class);
    Route::resource('categories', CategoryController::class);
});

// Socialite routes example for GitHub login (can add others similarly)
Route::get('/login/github', fn() => Socialite::driver('github')->redirect())->name('login.github');
Route::get('/login/github/callback', function () {
    $githubUser = Socialite::driver('github')->user();

    // Find or create the user...
    $user = \App\Models\User::firstOrCreate(
        ['email' => $githubUser->getEmail()],
        [
            'name' => $githubUser->getName() ?? $githubUser->getNickname(),
            'password' => bcrypt(str()->random(16))
        ] // Random password since Socialite manages auth
    );
    Auth::login($user);
    return redirect()->intended('/');
});


Route::get('/login/google', fn() => Socialite::driver('google')->redirect())->name('login.google');

Route::get('/login/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    $user = \App\Models\User::firstOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName() ?: $googleUser->getNickname(),
            'password' => bcrypt(str()->random(16))
        ]
    );

    Auth::login($user);

    return redirect()->intended('/');

});
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }
    return back();
})->name('lang.switch');
