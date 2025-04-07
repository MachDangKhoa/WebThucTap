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
        <a class="nav-link" href="#api-usage"><i class="fas fa-chart-line"></i> API Usage</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#dataset"><i class="fas fa-image"></i> Quản lý User</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#model-config"><i class="fas fa-cogs"></i> Model & Ngưỡng</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#logs"><i class="fas fa-history"></i> Quản lý thông tin tranh</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#system-info"><i class="fas fa-info-circle"></i> Thông tin hệ thống</a>
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
  <h2 class="mb-4">Bảng điều khiển Quản trị</h2>

  <div class="row">
    <!-- Card 1: API Usage -->
    <div class="col-md-6" id="api-usage">
      <div class="card border-primary">
        <div class="card-header bg-primary text-white">#1 Quản lý API Usage</div>
        <div class="card-body">
          <p>Thống kê số lượt gọi API trong ngày, tháng, người dùng...</p>
        </div>
      </div>
    </div>

    <!-- Card 2: Dataset -->
    <div class="col-md-6" id="dataset">
      <div class="card border-success">
        <div class="card-header bg-success text-white">#3 Quản lý User</div>
        <div class="card-body">
          <p>Danh sách người dùng, vai trò, trạng thái tài khoản, và các thao tác quản lý như thêm, sửa, xóa người dùng...</p>
        </div>
      </div>
    </div>

    <!-- Card 3: Model config -->
    <div class="col-md-6" id="model-config">
      <div class="card border-warning">
        <div class="card-header bg-warning text-dark">#4 Cấu hình Model & Ngưỡng</div>
        <div class="card-body">
          <p>Đang dùng model: <strong>DINOv2</strong>, ngưỡng similarity: <strong>0.80</strong></p>
        </div>
      </div>
    </div>

    <!-- Card 4: Logs -->
    <div class="col-md-6" id="logs">
      <div class="card border-danger">
        <div class="card-header bg-danger text-white">#5 Quản lý thông tin tranh</div>
        <div class="card-body">
        <p>Danh sách các tranh đã nhận diện, trạng thái xử lý, thông tin tác giả, năm sáng tác, và các truy vấn gần đây liên quan đến tranh.</p>
        </div>
      </div>
    </div>

    <!-- Card 5: System Info -->
    <div class="col-md-12" id="system-info">
      <div class="card border-dark">
        <div class="card-header bg-dark text-white">#7 Thông tin hệ thống</div>
        <div class="card-body">
          <p>Phiên bản: v1.0.0 | RAM: 16GB | CPU: 8-core | Tải trung bình: 15%</p>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Footer -->
<div class="footer mt-4">
  <p>© 2025 Hệ Thống Nhận Diện Tranh - Admin</p>
</div>

</body>
</html>
