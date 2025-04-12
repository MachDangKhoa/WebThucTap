<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artwork Recognition</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh; 
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

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 95px;
            left: -250px;
            width: 250px;
            min-height: 100%;
            background-color: #f5f5dc;
            color: black;
            padding-top: 20px;
            overflow-y: auto;
            z-index: 0;
            transition: left 0.3s ease;
        }

        .sidebar a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            background-color: #f5f5dc;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #d4e157;
            color: white;
        }

        .main-content {
            padding: 30px;
            margin-left: 0; /* Không margin trái khi sidebar ẩn */
            transition: margin-left 0.3s ease;
            flex: 1;
        }

        .card {
            margin-bottom: 20px;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .dropdown-menu {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 999;
        }

        .dropdown-item:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark px-4">
  <a class="navbar-brand" href="{{ route('dashboard') }}">🎨 Admin - Painting Identification</a>
  <div class="collapse navbar-collapse justify-content-end">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('predict') }}"><i class="fas fa-image"></i> Painting Identification</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('paintings.select') }}"><i class="fas fa-user"></i> Painting Information</a>
      </li>
      @if(Auth::check())
      <li class="nav-item">
        <a href="{{ route('account.edit', Auth::user()->id) }}" class="nav-link text-white">
            Xin chào, {{ Auth::user()->username }}
        </a>
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
<!-- Toggle Buttons (sửa lại) -->
<div style="position: fixed; top: 100px; left: 10px; z-index: 1001;">
    <button class="toggle-btn open-btn btn btn-secondary" id="open-btn">
        <i class="fas fa-bars"></i>
    </button>
    <button class="toggle-btn close-btn btn btn-secondary" id="close-btn" style="display: none;">
        <i class="fas fa-times"></i>
    </button>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h3 class="text-center">Artwork Recognition</h3>
    <a href="{{ route('predict') }}">Painting Identification</a>
    <a href="{{ route('paintings.select') }}">Painting Information</a>
</div>

    <!-- Main Content -->
<div class="main-content" id="main-content">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let sidebarOpen = false;

        document.getElementById('open-btn').addEventListener('click', function() {
            sidebarOpen = true;
            document.getElementById('sidebar').style.left = '0';
            document.getElementById('main-content').style.marginLeft = '250px';
            document.getElementById('open-btn').style.display = 'none';
            document.getElementById('close-btn').style.display = 'block';
        });

        document.getElementById('close-btn').addEventListener('click', function() {
            sidebarOpen = false;
            document.getElementById('sidebar').style.left = '-250px';
            document.getElementById('main-content').style.marginLeft = '0';
            document.getElementById('open-btn').style.display = 'block';
            document.getElementById('close-btn').style.display = 'none';
        });
    </script>
</body>
</html>
