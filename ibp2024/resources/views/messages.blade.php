@extends('layout')

@section('title', 'Mesajlar')

@section('content')
<div class="container mt-4">
    <h2>Mesajlar</h2>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Gönderen</th>
                <th scope="col">Alıcı</th>
                <th scope="col">Mesaj</th>
                <th scope="col">Tarih</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $message)
            <tr>
                <td>{{ $message->id }}</td>
                <td>{{ $message->sender->name }}</td>
                <td>{{ $message->receiver->name }}</td>
                <td>{{ $message->message }}</td>
                <td>{{ $message->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ auth()->user()->role == 'admin' ? route('admin.panel') : route('user.panel') }}" class="btn btn-secondary mt-2">Geri</a>

</div>
@endsection
