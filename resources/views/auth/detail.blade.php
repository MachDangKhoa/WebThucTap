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
            margin-left: 0;
            transition: margin-left 0.3s ease;
            flex: 1;
        }

        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark px-4">
  <a class="navbar-brand" href="#">🎨 Admin - Painting Identification</a>
  <div class="collapse navbar-collapse justify-content-end">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('predict') }}"><i class="fas fa-image"></i> Painting Identification</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('paintings.select') }}"><i class="fas fa-user"></i> Painting Information</a>
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

<div class="container mt-5">
    <h2 class="text-center mb-4">Danh sách tranh từ: {{ $source ?? 'Nguồn' }}</h2>


    {{-- Thông báo lỗi --}}
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- Form chọn nguồn dữ liệu --}}
    <form action="{{ route('paintings.view_detail_redirect') }}" method="GET" class="mb-4">
        <label for="type" class="form-label">Chọn nguồn dữ liệu:</label>
        <select name="type" id="type" class="form-select mb-2" required>
            <option value="">-- Chọn nguồn --</option>
            <option value="db" {{ $source === 'Dataset Cosine' ? 'selected' : '' }}>Dataset Cosine</option>
            <option value="google" {{ $source === 'Google Image' ? 'selected' : '' }}>Google Image</option>
        </select>
        <button type="submit" class="btn btn-primary mt-2">Xem thông tin</button>
    </form>

    {{-- Nếu có danh sách tranh --}}
    @if(isset($paintings) && $paintings->isNotEmpty())
        <div class="row">
            @foreach($paintings as $painting)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ $source === 'Dataset Cosine' ? $painting->img_url_db : $painting->img_url_gg }}" class="card-img-top" style="max-height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $source === 'Dataset Cosine' ? $painting->painting_title : $painting->title_gg }}
                            </h5>

                            <p><strong>Họa sĩ:</strong> {{ $source === 'Dataset Cosine' ? $painting->artist_db : $painting->artist_gg }}</p>
                            <p><strong>Phong cách:</strong> {{ $source === 'Dataset Cosine' ? $painting->style_db : $painting->style_gg }}</p>

                            @if($source === 'Dataset Cosine')
                                <p><strong>Độ tương đồng:</strong> {{ $painting->similarity }}</p>
                                <p><strong>Nhiếp ảnh gia:</strong> {{ $painting->photographer }}</p>
                                <p><strong>Mô tả:</strong> {{ $painting->description ?? 'Không có' }}</p>
                            @else
                                <p><strong>Thể loại:</strong> {{ $painting->genre_gg }}</p>
                                <p><strong>Năm:</strong> {{ $painting->year_gg }}</p>
                                <p><strong>Mô tả:</strong> {{ $painting->description_gg }}</p>
                                <p><strong>Đặc điểm nghệ thuật:</strong> {{ $painting->artistic_features_gg }}</p>
                                <p><strong>Thông tin bổ sung:</strong> {{ $painting->additional_info_gg }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center">Không có tranh nào được nhận diện trong nguồn {{ $source }}.</p>
    @endif
</div>


</body>
</html>
