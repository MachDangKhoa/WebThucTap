<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artwork Recognition</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">  
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bodoni Moda', cursive;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
         /* Header Styles */
         header {
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px 0;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 90%;
            margin: 0 auto;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 30px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 700;
            transition: color 0.3s ease, transform 0.3s ease;
            padding: 10px 15px;
        }

        nav ul li a:hover {
            color: #3498db;
            transform: scale(1.1);
        }

        /* Navbar Style */
        .navbar {
            background: white;
            padding: 15px 30px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            color: white;
            font-family: 'Dancing Script', cursive;
            font-size: 1.3rem;
            letter-spacing: 1px;
            transition: color 0.3s ease;
        }

        .navbar-brand:hover {
            color: #1abc9c;
            transform: scale(1.1);
        }
        
        /* Navbar Menu */
        .navbar-nav {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .navbar-nav .nav-item {
            margin-left: 20px;
        }

        .navbar-nav .nav-link {
            color: white;
            font-size: 1rem;
            padding: 8px 15px;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #1abc9c;
            transform: scale(1.1);
        }

        /* Active Link Style */
        .navbar-nav .nav-item.active .nav-link {
            color: #1abc9c;
            font-weight: bold;
        }

        /* Dropdown Menu */
        .navbar-nav .nav-item.dropdown .nav-link {
            position: relative;
        }

        .navbar-nav .nav-item.dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            transition: opacity 0.3s ease, transform 0.3s ease;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 60px;
                left: -250px;
                width: 250px;
                min-height: 100%;
                transition: left 0.3s ease;
            }

            .main-content {
                margin-left: 0;
            }

            .navbar {
                padding: 10px 20px;
            }

            .navbar-nav {
                flex-direction: column;
                align-items: center;
            }

            .navbar-nav .nav-item {
                margin: 10px 0;
            }

            .navbar-nav .nav-link {
                font-size: 1.2rem;
            }

            .navbar-brand {
                font-size: 1.3rem;
            }

            .toggle-btn {
                display: block;
            }

            .card {
                margin-bottom: 15px;
            }

            /* Card image responsiveness */
            .card-img-top {
                max-height: 200px;
                object-fit: cover;
            }
        }

        @media (min-width: 768px) {
            .toggle-btn {
                display: none;
            }
        }

        /* Button for toggling sidebar */
        .toggle-btn {
            position: fixed;
            top: 100px;
            left: 10px;
            z-index: 1001;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light px-4" style="background-color: white;">
    <a class="navbar-brand" href="{{ route('dashboard') }}">🎨Art Paintings Recognition</a>
    <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('predict') }}"><i class="fas fa-eye"></i> Painting Identification</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('paintings.select') }}"><i class="fas fa-image"></i> Painting Information</a>
        </li>
        @if(Auth::check())
        <li class="nav-item">
            <a href="{{ route('account.edit', Auth::user()->id) }}" class="nav-link">
                <i class="fas fa-user"></i> Xin chào, {{ Auth::user()->username }}
            </a>
        </li>
        @endif
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
            </form>
        </li>
        </ul>
    </div>
</nav>

<!-- Main Content -->
<div class="main-content" id="main-content">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Danh sách tranh từ: {{ $source ?? 'nguồn' }}</h2>

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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
