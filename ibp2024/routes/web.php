<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KitapController;
use App\Http\Controllers\KullaniciController;
use App\Http\Controllers\DuyuruController;
use App\Http\Controllers\KiralamaController;
use App\Models\Kitap;
use App\Http\Controllers\MessagesController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

//KULLANIICI İŞLEMLER
Route::get('/login', [KullaniciController::class, 'login'])->name('login');
Route::post('/login', [KullaniciController::class, 'loginPost'])->name('login.post');
Route::get('/registration', [KullaniciController::class, 'registration'])->name('registration');
Route::post('/registration', [KullaniciController::class, 'registrationPost'])->name('registration.post');
Route::get('/logout',[KullaniciController::class, 'logout'])->name('logout');
Route::post('/user/update-password', [KullaniciController::class, 'updatePassword'])->name('user.update.password');
Route::post('/kullanici/tanimla', [KullaniciController::class, 'tanimla'])->name('kullanici.tanimla');
Route::post('/kullanici/guncelle', [KullaniciController::class, 'guncelle'])->name('kullanici.guncelle');
Route::post('/kullanici/sil', [KullaniciController::class, 'kullaniciSil'])->name('kullanici.sil');


//KİTAP İŞLEM
Route::match(['get', 'post'], '/kitap/kaydi', [KitapController::class, 'kaydet'])->name('kitap.kaydi');
Route::post('/kitap/sil', [KitapController::class, 'sil'])->name('kitap.sil');


//DUYURU İŞLEM
Route::post('/duyuru/olustur', [DuyuruController::class, 'duyuruOlustur'])->name('duyuru.olustur');
Route::post('/duyuru/guncelle', [DuyuruController::class, 'duyuruGuncelle'])->name('duyuru.guncelle');
Route::post('/duyuru/sil', [DuyuruController::class, 'duyuruSil'])->name('duyuru.sil');


//Kitap kiralama


Route::middleware('auth')->group(function () {
    // Kitap Kiralama
    Route::post('/kirala/{kitap}', [KiralamaController::class, 'kirala'])->name('kitap.kirala');

    // ADMIN PANEL
    Route::get('/admin/panel', [KullaniciController::class, 'adminPanel'])->name('admin.panel'); // KullaniciController'a yönlendirdik
    Route::post('/kullanici/tanimla', [KullaniciController::class, 'tanimla'])->name('kullanici.tanimla');
    Route::post('/kullanici/guncelle', [KullaniciController::class, 'guncelle'])->name('kullanici.guncelle');
    Route::post('/kullanici/sil', [KullaniciController::class, 'kullaniciSil'])->name('kullanici.sil');

    // KULLANICI PANELİ

    Route::get('/user/panel', [KullaniciController::class, 'userPanel'])->name('user.panel'); // Rota güncellendi
    Route::post('/user/update-password', [KullaniciController::class, 'updatePasswordForUser'])->name('user.update.password'); // Rota eklendi


    // Mesaj İşlemleri
    Route::get('/messages/create', [MessagesController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessagesController::class, 'store'])->name('messages.store');
    Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');
});
