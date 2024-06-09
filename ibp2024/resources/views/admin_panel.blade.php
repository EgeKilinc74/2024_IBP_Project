@extends('layout')

@section('title', 'Admin Paneli')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Admin Paneli</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="accordion" id="adminAccordion">
              <div class="accordion-item">
                <h2 class="accordion-header" id="kullaniciIslemleriHeading">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#kullaniciIslemleriCollapse" aria-expanded="true" aria-controls="kullaniciIslemleriCollapse">
                        Kullanıcı İşlemleri
                    </button>
                </h2>
                <div id="kullaniciIslemleriCollapse" class="accordion-collapse collapse show" aria-labelledby="kullaniciIslemleriHeading" data-bs-parent="#adminAccordion">
                    <div class="accordion-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Kullanıcı Adı</th>
                                    <th scope="col">E-posta</th>
                                    <th scope="col">Rol</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h3 class="mt-4">Kullanıcı Ekle</h3>
                        <form action="{{ route('kullanici.tanimla') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">İsim:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="İsim" required>
                            </div>
                            <div class="form-group">
                                <label for="email">E-posta:</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-posta" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Parola:</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Parola" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Kullanıcı Ekle</button>
                        </form>

                        <hr>

                        <h3 class="mt-4">Kullanıcı Sil</h3>
                        <form action="{{ route('kullanici.sil') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="kullanici_id">Silinecek Kullanıcı ID:</label>
                                <input type="text" class="form-control" id="kullanici_id" name="kullanici_id" placeholder="Silinecek Kullanıcı ID" required>
                            </div>
                            <button type="submit" class="btn btn-danger">Kullanıcı Sil</button>
                        </form>

                        <hr>

                        <h3 class="mt-4">Kullanıcı Güncelle</h3>
                        <form action="{{ route('kullanici.guncelle') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="kullanici_id_guncelle">Güncellenecek Kullanıcı ID:</label>
                                <input type="text" class="form-control" id="kullanici_id_guncelle" name="kullanici_id_guncelle" placeholder="Güncellenecek Kullanıcı ID" required>
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

            <div class="accordion-item">
              <h2 class="accordion-header" id="kutuphaneIslemleriHeading">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kutuphaneIslemleriCollapse" aria-expanded="false" aria-controls="kutuphaneIslemleriCollapse">
                      Kütüphane İşlemleri
                  </button>
              </h2>
              <div id="kutuphaneIslemleriCollapse" class="accordion-collapse collapse" aria-labelledby="kutuphaneIslemleriHeading" data-bs-parent="#adminAccordion">
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

                      <h3 class="mt-4">Kitap Ekle</h3>
                      <form action="{{ route('kitap.kaydi') }}" method="post">
                          @csrf
                          <div class="form-group">
                              <label for="kitap_adi">Kitap Adı:</label>
                              <input type="text" class="form-control" id="kitap_adi" name="kitap_adi" placeholder="Kitap Adı" required>
                          </div>
                          <div class="form-group">
                              <label for="yazar">Yazar:</label>
                              <input type="text" class="form-control" id="yazar" name="yazar" placeholder="Yazar" required>
                          </div>
                          <div class="form-group">
                              <label for="mevcutluk">Mevcutluk:</label>
                              <input type="number" class="form-control" id="mevcutluk" name="mevcutluk" value="1" min="1">
                          </div>
                          <button type="submit" class="btn btn-success">Kitap Ekle</button>
                      </form>

                      <hr>

                      <h3 class="mt-4">Kitap Sil</h3>
                      <form action="{{ route('kitap.sil') }}" method="post">
                          @csrf
                          <div class="form-group">
                              <label for="kitap_id">Silinecek Kitap ID:</label>
                              <input type="text" class="form-control" id="kitap_id" name="kitap_id" placeholder="Silinecek Kitap ID" required>
                          </div>
                          <button type="submit" class="btn btn-danger">Kitap Sil</button>
                      </form>
                  </div>
              </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="duyuruIslemleriHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#duyuruIslemleriCollapse" aria-expanded="false" aria-controls="duyuruIslemleriCollapse">
                    Duyuru İşlemleri
                </button>
            </h2>
            <div id="duyuruIslemleriCollapse" class="accordion-collapse collapse" aria-labelledby="duyuruIslemleriHeading" data-bs-parent="#adminAccordion">
                <div class="accordion-body">
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

                    <h3 class="mt-4">Duyuru Oluştur</h3>
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

                    <h3 class="mt-4">Duyuru Güncelle</h3>
                    <form action="{{ route('duyuru.guncelle') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="duyuru_id_guncelle">Güncellenecek Duyuru ID:</label>
                            <input type="text" class="form-control" id="duyuru_id_guncelle" name="duyuru_id_guncelle" placeholder="Güncellenecek Duyuru ID" required>
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

                    <h3 class="mt-4">Duyuru Sil</h3>
                    <form action="{{ route('duyuru.sil') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="duyuru_id_sil">Silinecek Duyuru ID:</label>
                            <input type="text" class="form-control" id="duyuru_id_sil" name="duyuru_id_sil" placeholder="Silinecek Duyuru ID" required>
                        </div>
                        <button type="submit" class="btn btn-danger">Duyuruyu Sil</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="mesajlarHeading">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mesajlarCollapse" aria-expanded="false" aria-controls="mesajlarCollapse">
                  Mesajlar
              </button>
          </h2>
          <div id="mesajlarCollapse" class="accordion-collapse collapse" aria-labelledby="mesajlarHeading" data-bs-parent="#adminAccordion">
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

                  <h3 class="mt-4">Mesaj Gönder</h3>
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
                          <textarea name="message" id="message" class="form-control" rows="3" required></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary">Gönder</button>
                  </form>
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
      // Sayfa yüklendiğinde aktif sekmeyi localStorage'dan al
      const activeTab = localStorage.getItem('activeTab');
      if (activeTab) {
          const button = document.querySelector(`button[data-bs-target="#${activeTab}"]`);
          if (button) {
              button.classList.add('active');
              const collapse = new bootstrap.Collapse(document.getElementById(activeTab));
              collapse.show();
          }
      }

      // Herhangi bir accordion butonuna tıklandığında aktif sekmeyi localStorage'a kaydet
      const accordionButtons = document.querySelectorAll('.accordion-button');
      accordionButtons.forEach(button => {
          button.addEventListener('click', function () {
              const targetId = this.getAttribute('data-bs-target');
              localStorage.setItem('activeTab', targetId.substring(1)); // # karakterini kaldır
          });
      });
  });
  </script>

@endsection
