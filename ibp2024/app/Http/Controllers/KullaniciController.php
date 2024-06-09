<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kitap;
use App\Models\Duyuru;
use App\Models\Messages;

class KullaniciController extends Controller
{

    public function showProfile()
{
    // Tüm duyuruları al
    $duyurular = Duyuru::all();

    // Kullanıcı panelinde duyuruları göster
    return view('kullanici_panel', compact('duyurular'));
}

    public function login()
    {
        if (Auth::check()) {
            return redirect(route('home'));
        }
        return view('login');
    }

    public function registration()
    {
        if (Auth::check()) {
            return redirect(route('home'));
        }
        return view('registration');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.panel');
            } else {
                return redirect()->route('user.panel');
            }
        }
        return redirect(route('login'))->with("error", "Login details are not valid");
    }

    public function registrationPost(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if ($user) {
            return redirect(route('login'))->with("success", "Registration success, Login to access the app");
        }
        return redirect(route('registration'))->with("error", "Registration failed, try again.");
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if ($user instanceof \Illuminate\Database\Eloquent\Model) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'Current password is incorrect.');
            }

            $user->password = Hash::make($request->new_password);
            $user->save(); // Kullanıcının parolasını güncelle

            return redirect()->back()->with('success', 'Password updated successfully.');
        } else {
            return redirect()->back()->with('error', 'User model is not valid.');
        }
    }

    public function guncelle(Request $request)
    {
        // Güncellenecek kullanıcının ID'sini alın
        $kullaniciId = $request->input('kullanici_id_guncelle');

        // Yeni şifreyi alın
        $yeniSifre = $request->input('yeni_sifre');

        // Kullanıcıyı bulun
        $kullanici = User::find($kullaniciId);

        // Kullanıcı varsa güncelle
        if ($kullanici) {
            // Yeni şifreyi ayarlayın
            $kullanici->password = bcrypt($yeniSifre); // Örnek olarak şifreyi hashleyelim

            // Kullanıcıyı kaydedin
            $kullanici->save();

            return redirect()->back()->with('success', 'Kullanıcı başarıyla güncellendi.');
        } else {
            return redirect()->back()->with('error', 'Kullanıcı bulunamadı.');
        }
    }

    public function tanimla(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->role = 'user'; // 'user' değerinin veritabanındaki ENUM ile eşleştiğinden emin olun
    $user->save();

    return redirect()->route('admin.panel')->with('success', 'Kullanıcı başarıyla tanımlandı.');
}


    public function kullaniciSil(Request $request)
{
    $request->validate([
        'kullanici_id' => 'required|integer|exists:users,id',
    ]);

    $kullanici = User::find($request->kullanici_id);

    if (!$kullanici) {
        return redirect()->back()->with('error', 'Kullanıcı bulunamadı.');
    }

    $kullanici->delete();

    return redirect()->back()->with('success', 'Kullanıcı başarıyla silindi.');
}


public function adminPanel()
    {
        $users = User::all();
        $kitaplar = Kitap::all();
        $duyurular = Duyuru::all();

        $currentUserId = Auth::id();

        $messages = Messages::where(function ($query) use ($currentUserId) {
            $query->where('sender_id', $currentUserId)
                  ->orWhere('receiver_id', $currentUserId);
        })->with(['sender', 'receiver'])->get();

        return view('admin_panel', compact('users', 'kitaplar', 'duyurular', 'messages'));
    }

    public function userPanel()
    {
        $users = User::all();
        $duyurular = Duyuru::all();
        $kitaplar = Kitap::all();
        $currentUserId = Auth::id();
        // $messages = Messages::with(['sender', 'receiver'])->get();

        $messages = Messages::where(function ($query) use ($currentUserId) {
            $query->where('sender_id', $currentUserId)
                  ->orWhere('receiver_id', $currentUserId);
        })->with(['sender', 'receiver'])->get();

        return view('kullanici_panel', compact('users', 'kitaplar', 'duyurular', 'messages'));
    }


    public function updatePasswordForUser(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'yeni_sifre' => 'required|string|min:8|confirmed',
            ]);

            $user = User::find(Auth::id());

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with("error", "Mevcut şifre yanlış.");
            }

            $user->password = Hash::make($request->yeni_sifre);
            $user->save();

            return back()->with("success", "Şifre başarıyla güncellendi.");
        } catch (\Exception $e) {
            return back()->with("error", "Şifre güncellenirken bir hata oluştu: " . $e->getMessage());
        }
    }




}
