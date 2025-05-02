<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website Description Here">
    <meta name="keywords" content="Keywords, for, your, website">
    <title>@yield('title', 'Cấu Hình Website')</title>
    
    <!-- Link đến Bootstrap và các thư viện cần thiết -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('storage/' . \App\Models\SiteConfig::getConfig('site_favicon')) }}" type="image/x-icon">

    @stack('styles') <!-- Để có thể thêm CSS từ các view con -->
</head>
<body>
    <div class="container mt-5">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="{{ url('/') }}">Trang Chủ</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.index') }}">Cấu Hình</a>
                    </li>
                    <!-- Thêm các liên kết khác tại đây -->
                </ul>
            </div>
        </nav>

        <div class="content">
            @yield('content') <!-- Phần nội dung chính sẽ được thay thế từ các view con -->
        </div>
    </div>

    <!-- Link đến các script JavaScript cần thiết -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts') <!-- Để có thể thêm JavaScript từ các view con -->
</body>
</html>
