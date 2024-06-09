@extends('layout')

@section('title', 'Kullanici Paneli')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">{{ __('Hoş Geldiniz,') }} {{ auth()->user()->name }}!</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="accordion" id="userAccordion">

                <div class="accordion-item">
                    <h2 class="accordion-header" id="kitaplarHeading">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#kitaplarCollapse" aria-expanded="true" aria-controls="kitaplarCollapse">
                            Kitap Listesi
                        </button>
                    </h2>
                    <div id="kitaplarCollapse" class="accordion-collapse collapse show" aria-labelledby="kitaplarHeading" data-bs-parent="#userAccordion">
                        <div class="accordion-body">
                            <form id="searchForm">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="searchInput" placeholder="Kitap Adı Ara...">
                                    <button class="btn btn-outline-secondary" type="submit">Ara</button>
                                </div>
                            </form>
                            <table class="table" id="kitaplarTablosu">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Kitap Adı</th>
                                        <th scope="col">Yazar</th>
                                        <th scope="col">Mevcutluk</th>
                                        <th scope="col">İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kitaplar as $kitap)
                                    <tr>
                                        <td>{{ $kitap->id }}</td>
                                        <td>{{ $kitap->kitap_adi }}</td>
                                        <td>{{ $kitap->yazar }}</td>
                                        <td>{{ $kitap->mevcutluk }}</td>
                                        <td>
                                            @if($kitap->mevcutluk > 0)
                                                <button class="btn btn-primary btn-sm kirala-btn" data-kitap-id="{{ $kitap->id }}">Kirala</button>
                                            @else
                                                <span class="text-danger">Kitap mevcut değil</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="duyurularHeading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#duyurularCollapse" aria-expanded="false" aria-controls="duyurularCollapse">
                            Duyurular
                        </button>
                    </h2>
                    <div id="duyurularCollapse" class="accordion-collapse collapse" aria-labelledby="duyurularHeading" data-bs-parent="#userAccordion">
                        <div class="accordion-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Başlık</th>
                                        <th scope="col">İçerik</th>
                                        <th scope="col">Gönderen</th>
                                        <th scope="col">Gönderilme Zamanı</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($duyurular as $duyuru)
                                    <tr>
                                        <td>{{ $duyuru->baslik }}</td>
                                        <td>{{ $duyuru->icerik }}</td>
                                        <td>{{ $duyuru->gonderen }}</td>
                                        <td>{{ $duyuru->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="mesajlarHeading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mesajlarCollapse" aria-expanded="false" aria-controls="mesajlarCollapse">
                            Mesajlar
                        </button>
                    </h2>
                    <div id="mesajlarCollapse" class="accordion-collapse collapse" aria-labelledby="mesajlarHeading" data-bs-parent="#userAccordion">
                        <div class="accordion-body">
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
                                    @if(isset($messages))
                                    @foreach($messages as $message)
                                        <tr>
                                            <td>{{ $message->id }}</td>
                                            <td>{{ $message->sender->name }}</td>
                                            <td>{{ $message->receiver->name }}</td>
                                            <td>{{ $message->message }}</td>
                                            <td>{{ $message->created_at }}</td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <form action="{{ route('messages.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="receiver_id">Alıcı:</label>
                                    <select name="receiver_id" id="receiver_id" class="form-control">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="message">Mesaj:</label>
                                    <textarea name="message" id="message" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Gönder</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="sifreHeading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sifreCollapse" aria-expanded="false" aria-controls="sifreCollapse">
                            Şifre Güncelleme
                        </button>
                    </h2>
                    <div id="sifreCollapse" class="accordion-collapse collapse" aria-labelledby="sifreHeading" data-bs-parent="#userAccordion">
                        <div class="accordion-body">
                            <form action="{{ route('user.update.password') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="current_password">Mevcut Şifre</label>
                                    <input id="current_password" type="password" class="form-control" name="current_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="new_password">Yeni Şifre</label>
                                    <input id="new_password" type="password" class="form-control" name="new_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="new_password_confirmation">Yeni Şifre Tekrar</label>
                                    <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Şifreyi Güncelle</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- JS KODLAR --}}
      {{-- Search Bar --}}
      <script>
        const searchInput = document.getElementById('searchInput');
        const kitapTableRows = document.querySelectorAll('#kitaplarTablosu tbody tr'); // Sadece kitap tablosu
        const searchForm = document.getElementById('searchForm');

        let timeout = null;

        searchForm.addEventListener('submit', (event) => {
            event.preventDefault();
            filterKitapTable();
        });

        searchInput.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(filterKitapTable, 300);
        });

        function filterKitapTable() {
            const filter = searchInput.value.toLowerCase();
            let visibleRows = 0;
            kitapTableRows.forEach(row => {
                const bookTitle = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const shouldShow = bookTitle.includes(filter);
                row.style.display = shouldShow ? '' : 'none';
                visibleRows += shouldShow ? 1 : 0;
            });

            if (visibleRows === 0 && filter !== '') {
                alert('Arama kriterlerine uygun kitap bulunamadı.');
            }
        }
  </script>



<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.kirala-btn').forEach(button => {
        button.addEventListener('click', function () {
            const kitapId = this.dataset.kitapId;

            if (confirm('Bu kitabı kiralamak istediğinize emin misiniz?')) {
                fetch(`/kirala/${kitapId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json', // Bu satırı ekleyin
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => {
                    if (!response.ok) { // Başarısız yanıtları kontrol et
                        return response.json().then(err => {
                            throw new Error(err.error || 'Bilinmeyen bir hata oluştu.');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        location.reload(); // Sayfayı yenile
                    } else {
                        alert(data.error || 'Bilinmeyen bir hata oluştu.');
                    }
                })
                .catch(error => {
                    console.error('Kiralama hatası:', error);
                    alert(error.message || 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
                });
            }
        });
    });
});

  </script>




@endsection
