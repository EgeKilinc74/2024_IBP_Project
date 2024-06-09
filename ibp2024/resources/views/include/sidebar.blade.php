<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>@yield('title')</title>
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            padding: 20px;
            background-color: #f8f9fa;
            overflow-y: auto;
        }

        .content {
            margin-left: 250px; /* Sidebar genişliği kadar boşluk bırak */
            padding: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.panel') }}#kullaniciIslemleri">{{ __('Kullanıcı İşlemleri') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.panel') }}#kutuphaneIslemleri">{{ __('Kütüphane İşlemleri') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.panel') }}#duyuruIslemleri">{{ __('Duyuru İşlemleri') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.panel') }}#mesajIslemleri">{{ __('Mesajlar') }}</a>
            </li>
        </ul>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
