@extends('layout')

@section('title', 'Admin Paneli')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- Kullanıcı İşlemleri -->
        <div class="col-md-4">
            <div class="card mt-4">
                <div class="card-header">{{ __('Kullanıcı İşlemleri') }}</div>
                <div class="card-body">
                  {{-- List of users  --}}
                  <table class="table" >
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Kullanıcı Adı</th>
                            <th scope="col">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                    <!-- Kullanıcı Tanımlama Formu -->
                    <form action="{{ route('kullanici.tanimla') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">İsim:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="İsim">
                        </div>
                        <div class="form-group">
                            <label for="email">E-posta:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-posta">
                        </div>
                        <div class="form-group">
                            <label for="password">Parola:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Parola">
                        </div>
                        <button type="submit" class="btn btn-primary">Kullanıcı Tanımla</button>
                    </form>
                    <hr>

                    <!-- Kullanıcı Silme Formu -->
                    <div class="card mt-4">
                        <div class="card-header">{{ __('Kullanıcı Silme İşlemleri') }}</div>
                        <div class="card-body">
                            <form action="{{ route('kullanici.sil') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="kullanici_id">Silinecek Kullanıcı ID:</label>
                                    <input type="text" class="form-control" id="kullanici_id" name="kullanici_id" placeholder="Silinecek Kullanıcı ID">
                                </div>
                                <button type="submit" class="btn btn-danger">Kullanıcı Sil</button>
                            </form>
                        </div>
                    </div>
                    <hr>

                    <!-- Kullanıcı Güncelleme Formu -->
                    <form action="{{ route('kullanici.guncelle') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="kullanici_id_guncelle">Güncellenecek Kullanıcı ID:</label>
                            <input type="text" class="form-control" id="kullanici_id_guncelle" name="kullanici_id_guncelle" placeholder="Güncellenecek Kullanıcı ID">
                        </div>
                        <div class="form-group">
                            <label for="yeni_sifre">Yeni Şifre:</label>
                            <input type="password" class="form-control" id="yeni_sifre" name="yeni_sifre" placeholder="Yeni Şifre">
                        </div>
                        <button type="submit" class="btn btn-warning">Kullanıcıyı Güncelle</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kütüphane İşlemleri -->
        <div class="col-md-4">
            <div class="card mt-4">
                <div class="card-header">{{ __('Kütüphane İşlemleri') }}</div>
                <div class="card-body">
                  {{-- seachbar --}}
                  <form id="searchForm">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="searchInput" placeholder="Kitap Adı Ara...">
                        <button class="btn btn-outline-secondary" type="submit">Ara</button>
                    </div>
                </form>
                  {{-- list of books --}}
                  <table class="table" id="kitaplarTablosu">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Kitap Adı</th>
                            <th scope="col">Yazar</th>
                            <th scope="col">Mevcutluk</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($kitaplar as $kitap)
                      <tr>
                          <td>{{ $kitap->id }}</td>
                          <td>{{ $kitap->kitap_adi }}</td>
                          <td>{{ $kitap->yazar }}</td>
                          <td>{{ $kitap->mevcutluk }}</td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
                    <!-- Kitap Kaydı Formu -->
                    <form action="{{ route('kitap.kaydi') }}" method="post">
                      @csrf
                      <div class="form-group">
                          <label for="kitap_adi">Kitap Adı:</label>
                          <input type="text" class="form-control" id="kitap_adi" name="kitap_adi" placeholder="Kitap Adı" required>
                      </div>
                      <div class="form-group">
                          <label for="yazar">Yazar:</label>
                          <input type="text" class="form-control" id="yazar" name="yazar" placeholder="Yazar">
                      </div>
                      <div class="form-group">
                          <label for="mevcutluk">Mevcutluk:</label>
                          <input type="number" class="form-control" id="mevcutluk" name="mevcutluk" value="1" min="1">
                      </div>
                      <button type="submit" class="btn btn-success">Kitap Kaydı Yap</button>
                  </form>
                    <hr>

                    <!-- Kitap Silme Formu -->
                    <form action="{{ route('kitap.sil') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="kitap_id">Silinecek Kitap ID:</label>
                            <input type="text" class="form-control" id="kitap_id" name="kitap_id" placeholder="Silinecek Kitap ID">
                        </div>
                        <button type="submit" class="btn btn-danger">Kitap Sil</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Duyuru İşlemleri -->
        <div class="col-md-4">
            <div class="card mt-4">
                <div class="card-header">{{ __('Duyuru İşlemleri') }}</div>
                <div class="card-body">
                  {{-- list of duyuru --}}
                  <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Başlık</th>
                            <th scope="col">İçerik</th>
                            <th scope="col">Gönderilme Zamanı</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($duyurular as $duyuru)
                      <tr>
                          <td>{{ $duyuru->id }}</td>
                          <td>{{ $duyuru->baslik }}</td>
                          <td>{{ $duyuru->icerik }}</td>
                          <td>{{ $duyuru->created_at }}</td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
                    <form action="{{ route('duyuru.olustur') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="baslik">Başlık:</label>
                            <input type="text" class="form-control" id="baslik" name="baslik" placeholder="Başlık" required>
                        </div>
                        <div class="form-group">
                            <label for="icerik">İçerik:</label>
                            <textarea class="form-control" id="icerik" name="icerik" placeholder="İçerik" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Duyuru Oluştur</button>
                    </form>
                    <hr>

                    <form action="{{ route('duyuru.guncelle') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="duyuru_id_guncelle">Güncellenecek Duyuru ID:</label>
                            <input type="text" class="form-control" id="duyuru_id_guncelle" name="duyuru_id_guncelle" placeholder="Güncellenecek Duyuru ID">
                        </div>
                        <div class="form-group">
                            <label for="yeni_baslik">Yeni Başlık:</label>
                            <input type="text" class="form-control" id="yeni_baslik" name="yeni_baslik" placeholder="Yeni Başlık">
                        </div>
                        <div class="form-group">
                            <label for="yeni_icerik">Yeni İçerik:</label>
                            <textarea class="form-control" id="yeni_icerik" name="yeni_icerik" placeholder="Yeni İçerik" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning">Duyuruyu Güncelle</button>
                    </form>
                    <hr>

                    <form action="{{ route('duyuru.sil') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="duyuru_id_sil">Silinecek Duyuru ID:</label>
                            <input type="text" class="form-control" id="duyuru_id_sil" name="duyuru_id_sil" placeholder="Silinecek Duyuru ID">
                        </div>
                        <button type="submit" class="btn btn-danger">Duyuruyu Sil</button>
                    </form>
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

@endsection
