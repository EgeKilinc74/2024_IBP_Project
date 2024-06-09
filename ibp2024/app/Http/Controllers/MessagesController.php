<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use App\Models\User;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function create()
    {
        $users = User::where('id', '!=', auth()->id())->get(); // Kendisi hariç diğer kullanıcıları al
        return view('messages.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $validatedData['sender_id'] = auth()->id(); // Oturum açmış kullanıcıyı gönderen olarak ayarla

        Messages::create($validatedData);

        return redirect()->route('messages.index')->with('success', 'Mesaj başarıyla gönderildi.');
        // return redirect()->route('admin.panel')->with('success', 'Mesaj başarıyla gönderildi.');
    }

    public function index()
    {
        // Kullanıcının gönderdiği ve aldığı tüm mesajları al
        $messages = Messages::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->with(['sender', 'receiver'])
            ->get();

        return view('messages', compact('messages'));
    }
}
