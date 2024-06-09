<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Duyuru;

class DuyuruController extends Controller
{
    public function duyuruOlustur(Request $request)
    {
        $request->validate([
            'baslik' => 'required|string|max:255',
            'icerik' => 'required|string',
        ]);

        // Yeni bir Duyuru modeli oluştur ve formdan gelen verileri kaydet
        $duyuru = Duyuru::create([
            'baslik' => $request->baslik,
            'icerik' => $request->icerik,
        ]);

        return redirect()->back()->with('success', 'Duyuru başarıyla oluşturuldu.');
    }

    public function duyuruGuncelle(Request $request)
    {
        // Güncellenecek duyurunun ID'sini al
        $duyuruId = $request->input('duyuru_id_guncelle');

        $request->validate([
            'duyuru_id_guncelle' => 'required|exists:duyurular,id',
            'yeni_baslik' => 'required|string|max:255',
            'yeni_icerik' => 'required|string',
        ]);

        // Duyuruyu bul ve güncelle
        $duyuru = Duyuru::findOrFail($duyuruId);
        $duyuru->baslik = $request->yeni_baslik;
        $duyuru->icerik = $request->yeni_icerik;
        $duyuru->save();

        return redirect()->back()->with('success', 'Duyuru başarıyla güncellendi.');
    }

    public function duyuruSil(Request $request)
    {
        // Silinecek duyurunun ID'sini al
        $duyuruId = $request->input('duyuru_id_sil');

        $request->validate([
            'duyuru_id_sil' => 'required|exists:duyurular,id',
        ]);

        // Duyuruyu bul ve sil
        $duyuru = Duyuru::findOrFail($duyuruId);
        $duyuru->delete();

        return redirect()->back()->with('success', 'Duyuru başarıyla silindi.');
    }
}
