<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriArtikelController;
use App\Http\Controllers\PenulisController;
use App\Http\Controllers\ArtikelController;

use App\Http\Controllers\FrontEndController;

Route::get('/', [FrontEndController::class, 'index'])->name('home');
Route::get('/live-search', [FrontEndController::class, 'liveSearch'])->name('live.search');
Route::get('/baca/{id}', [FrontEndController::class, 'show'])->name('baca');
Route::post('/artikel/{id}/reaksi', [FrontEndController::class, 'storeReaksi'])->name('reaksi.store');
Route::post('/artikel/{id}/view', [FrontEndController::class, 'trackView'])->name('view.store');
Route::get('/artikel/{id}/stats', [FrontEndController::class, 'getStats'])->name('stats.get');
Route::get('/kategori-artikel/{id}', [FrontEndController::class, 'byKategori'])->name('kategori.public');
Route::get('/cari', [FrontEndController::class, 'search'])->name('search');
Route::get('/tentang-kami', [FrontEndController::class, 'about'])->name('about');
Route::get('/redaksi', [FrontEndController::class, 'redaksi'])->name('redaksi');
Route::get('/profil-penulis/{user_name}', [FrontEndController::class, 'penulis'])->name('penulis.show');
Route::get('/kontak', [FrontEndController::class, 'contact'])->name('contact');
Route::get('/kebijakan-privasi', [FrontEndController::class, 'privacy'])->name('privacy');
Route::view('/offline', 'frontend.offline')->name('offline');

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('kategori', KategoriArtikelController::class)->except(['show']);
    Route::resource('penulis', PenulisController::class)->parameters(['penulis' => 'penulis'])->except(['show']);
    Route::resource('artikel', ArtikelController::class)->except(['show']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
