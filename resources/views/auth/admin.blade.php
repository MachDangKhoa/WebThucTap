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
  <a class="navbar-brand" href="{{ route('admin.dashboard') }}">🎨 Admin - Nhận diện tranh</a>
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

      @if(Auth::check())
      <li class="nav-item">
        <span class="nav-link text-white">Xin chào, {{ Auth::user()->username }}</span>
      </li>
      @endif

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
<div class="container mt-4">
        <h3>Danh họa tiêu biểu</h3>
        <div class="row">
            <!-- Leonardo da Vinci -->
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('storage/uploads/leonardo_da_vinci.jpg') }}" class="card-img-top" alt="Leonardo da Vinci">
                    <div class="card-body">
                        <h5 class="card-title">Leonardo da Vinci</h5>
                        <p class="card-text">Một trong những danh họa nổi tiếng nhất của thời kỳ Phục Hưng, nổi bật với các tác phẩm như "Mona Lisa" và "The Last Supper".</p>
                    </div>
                </div>
            </div>

            <!-- Vincent van Gogh -->
            <div class="col-md-4">
                <div class="card">  <!-- Giả sử id của Vincent van Gogh là 2 -->
                    <img src="{{ asset('storage/uploads/vincent_van_gogh.jpg') }}" class="card-img-top" alt="Vincent van Gogh">
                    <div class="card-body">
                        <h5 class="card-title">Vincent van Gogh</h5>
                        <p class="card-text">Danh họa người Hà Lan nổi tiếng với các tác phẩm như "Starry Night" và "Sunflowers".</p>
                    </div>
                </div>
            </div>

            <!-- Pablo Picasso -->
            <div class="col-md-4">
                <div class="card">  <!-- Giả sử id của Pablo Picasso là 3 -->
                    <img src="{{ asset('storage/uploads/pablo_picasso.jpg') }}" class="card-img-top" alt="Pablo Picasso">
                    <div class="card-body">
                        <h5 class="card-title">Pablo Picasso</h5>
                        <p class="card-text">Một trong những nghệ sĩ vĩ đại nhất của thế kỷ 20, nổi bật với các phong cách như lập thể và các tác phẩm như "Guernica".</p>
                    </div>
                </div>
            </div>
        </div>

        <h3>Thông tin tranh</h3>
        <div class="row">
            <!-- Leonardo da Vinci's artworks -->
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('storage/uploads/mona_lisa.jpg') }}" class="card-img-top" alt="Mona Lisa">
                    <div class="card-body">
                        <h5 class="card-title">Mona Lisa</h5>
                        <p class="card-text"><strong>Chủ đề:</strong> Portrait</p>
                        <p class="card-text"><strong>Chất liệu:</strong> Oil on Canvas</p>
                        <p class="card-text"><strong>Mô tả:</strong> Một bức tranh nổi tiếng của Leonardo da Vinci, biểu tượng của nghệ thuật Phục Hưng.</p>
                    </div>
                </div>
            </div>

            <!-- Vincent van Gogh's artworks -->
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('storage/uploads/starry_night.jpg') }}" class="card-img-top" alt="Starry Night">
                    <div class="card-body">
                        <h5 class="card-title">Starry Night</h5>
                        <p class="card-text"><strong>Chủ đề:</strong> Night Sky</p>
                        <p class="card-text"><strong>Chất liệu:</strong> Oil on Canvas</p>
                        <p class="card-text"><strong>Mô tả:</strong> Một trong những tác phẩm nổi bật của Vincent van Gogh, thể hiện bầu trời đêm đầy sao.</p>
                    </div>
                </div>
            </div>

            <!-- Pablo Picasso's artworks -->
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ url('storage/uploads/guernica.jpg') }}" class="card-img-top" alt="Guernica">
                    <div class="card-body">
                        <h5 class="card-title">Guernica</h5>
                        <p class="card-text"><strong>Chủ đề:</strong> Anti-War</p>
                        <p class="card-text"><strong>Chất liệu:</strong> Oil on Canvas</p>
                        <p class="card-text"><strong>Mô tả:</strong> Một bức tranh nổi tiếng của Pablo Picasso, thể hiện sự phản đối chiến tranh và bạo lực.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
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
