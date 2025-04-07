<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard - Hệ thống nhận diện tranh</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
    }

    .navbar {
      background-color: #1f2a3f;
    }

    .navbar-brand {
      font-weight: bold;
      color: white;
    }

    .navbar-brand:hover {
      color: #1abc9c;
    }

    .navbar-nav .nav-link {
      color: white;
      margin-left: 10px;
    }

    .navbar-nav .nav-link:hover {
      color: #1abc9c;
    }

    .main-content {
      padding: 30px;
    }

    .card {
      margin-bottom: 20px;
    }

    .footer {
      background-color: #1f2a3f;
      color: white;
      text-align: center;
      padding: 15px 0;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark px-4">
  <a class="navbar-brand" href="#">🎨 Admin - Nhận diện tranh</a>
  <div class="collapse navbar-collapse justify-content-end">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('accounts.index') }}"><i class="fas fa-user"></i> Manage User</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('api') }}"><i class="fas fa-chart-line"></i> API Usage</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('paintings.index') }}"><i class="fas fa-image"></i> Painting Information</a>
      </li>

      <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i> Đăng xuất
          </button>
        </form>
      </li>
    </ul>
  </div>
</nav>

<!-- Main Content -->
<div class="container main-content">
  
</div>

<!-- Footer -->
<div class="footer mt-4">
  <p>© 2025 Hệ Thống Nhận Diện Tranh - Admin</p>
  <p><i class="fas fa-info-circle"></i> Thông tin hệ thống:</p>
  <ul>
    <li><strong>Phiên bản:</strong> 1.0</li>
    <li><strong>Ngày phát hành:</strong> Tháng 5, 2025</li>
    <li><strong>API:</strong> RESTful API, các endpoint chính: <code>/predict</code></li>
    <li><strong>Liên kết tài liệu API:</strong> <a href="https://yourdomain.com/api-docs" target="_blank">Xem tài liệu API</a></li>
  </ul>
</div>


</body>
</html>
