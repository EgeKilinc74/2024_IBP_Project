@extends('layout')

@section('title', 'Kullanici Paneli')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">{{ __('Kitap Listesi') }}</div>
                <div class="card-body">
                  {{-- seachbar --}}
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
            <div class="card mt-4">
                <div class="card-header">{{ __('Duyurular') }}</div>
                <div class="card-body">
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
            <div class="card mt-4">
              <div class="card-header">{{ __('Şifre Güncelleme') }}</div>
              <div class="card-body">
                  <form action="{{ route('user.update.password') }}" method="POST">
                      @csrf
                      <div class="form-group">
                          <label for="current_password">{{ __('Mevcut Şifre') }}</label>
                          <input id="current_password" type="password" class="form-control" name="current_password" required>
                      </div>

                      <div class="form-group">
                          <label for="new_password">{{ __('Yeni Şifre') }}</label>
                          <input id="new_password" type="password" class="form-control" name="new_password" required>
                      </div>

                      <div class="form-group">
                          <label for="new_password_confirmation">{{ __('Yeni Şifre Tekrar') }}</label>
                          <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" required>
                      </div>

                      <button type="submit" class="btn btn-primary">{{ __('Şifreyi Güncelle') }}</button>
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
