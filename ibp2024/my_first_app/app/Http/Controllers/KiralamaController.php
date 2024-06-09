<?php

namespace App\Http\Controllers;

use App\Models\Kitap;
use App\Models\Kiralama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class KiralamaController extends Controller
{
    public function kirala(Kitap $kitap)
    {
        // Kullanıcı oturum açmış mı kontrolü
        if (!Auth::check()) {
            return response()->json(['error' => 'Kiralama yapmak için lütfen oturum açın.'], 401);
        }

        // Kitabın mevcut olup olmadığını kontrol et
        if ($kitap->mevcutluk > 0) {
            // Kullanıcının daha önce aynı kitabı kiralayıp kiralamadığını kontrol et
            $existingRental = Kiralama::where('user_id', auth()->user()->id)
                                      ->where('kitap_id', $kitap->id)
                                      ->whereNull('iade_tarihi')
                                      ->first();

            if ($existingRental) {
                return response()->json(['error' => 'Bu kitabı zaten kiraladınız.'], 400);
            }

            // Yeni kiralama kaydı oluştur
            Kiralama::create([
                'user_id' => auth()->user()->id,
                'kitap_id' => $kitap->id
            ]);

            // Kitabın mevcutluğunu azalt
            $kitap->mevcutluk--;
            $kitap->save();

            return response()->json(['success' => 'Kitap başarıyla kiralandı!']);
        } else {
            return response()->json(['error' => 'Kitap mevcut değil.'], 404);
        }
    }
}
