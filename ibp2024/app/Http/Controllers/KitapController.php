<?php

namespace App\Http\Controllers;

use App\Models\Kitap;
use Illuminate\Http\Request;

class KitapController extends Controller
{



    public function kaydet(Request $request)
    {
        $request->validate([
            'kitap_adi' => 'required',
            'yazar' => 'required',

            // Diğer alanlar için gerekli doğrulamaları buraya ekleyin
        ]);

        // Formdan gelen verileri al
        $kitapAdi = $request->input('kitap_adi');
        $yazar = $request->input('yazar'); // Örnek olarak bir yazar alanı olduğunu varsayalım
        $mevcutluk = $request->input('mevcutluk', 0);
        // Yeni bir Kitap modeli oluştur ve verileri ata
        $kitap = new Kitap();
        $kitap->kitap_adi = $kitapAdi;
        $kitap->yazar = $yazar;
        $kitap->mevcutluk = $mevcutluk;

        // Veritabanına kaydet
        $kitap->save();

        // Başarılı bir mesaj göndererek kullanıcıyı yönlendir
        return redirect()->route('kitap.kaydi')->with('success', 'Kitap başarıyla kaydedildi.');
    }

    public function sil(Request $request)
    {
        // Formdan gelen veriyi doğrulama
        $request->validate([
            'kitap_id' => 'required|integer|exists:kitaplar,id',
        ]);

        // Formdan gelen kitap ID'sini alın
        $kitapId = $request->input('kitap_id');

        // ID'ye göre kitabı bulun
        $kitap = Kitap::find($kitapId);

        // Eğer kitap bulunamazsa, hata mesajıyla geri dön
        if (!$kitap) {
            return redirect()->back()->with('error', 'Kitap bulunamadı.');
        }

        // Kitabı sil
        $kitap->delete();

        // Silme işlemi başarılı olduğunda başarı mesajıyla geri dön
        return redirect()->back()->with('success', 'Kitap başarıyla silindi.');
    }




}
