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
            color: black;
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
            color: black;
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

        /* Navbar Toggle Button */
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            font-size: 1.25rem;
            line-height: 1;
            background-color: transparent;
            transition: all 0.3s ease;
        }

        .navbar-toggler:focus {
            outline: none;
            box-shadow: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.55%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            width: 1.5em;
            height: 1.5em;
        }

        /* Mobile Menu Styles */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                position: fixed;
                top: 70px;
                left: 0;
                right: 0;
                background-color: white;
                padding: 20px;
                box-shadow: 0 5px 10px rgba(0,0,0,0.1);
                z-index: 999;
                max-height: calc(100vh - 70px);
                overflow-y: auto;
            }
            
            .navbar-nav {
                flex-direction: column;
                gap: 15px;
            }
            
            .nav-item {
                margin-left: 0 !important;
            }
            
            .nav-link {
                padding: 10px 15px;
                border-radius: 5px;
                transition: all 0.3s ease;
                display: block;
            }
            
            .nav-link:hover {
                background-color: #f8f9fa;
            }
            
            .btn-danger {
                width: 100%;
                text-align: left;
                padding: 10px 15px;
                margin-top: 10px;
            }
        }

        .main-content {
            padding: 30px;
            margin-left: 0;
            transition: margin-left 0.3s ease;
            flex: 1;
        }

        .card {
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
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
                padding: 15px;
            }

            .navbar {
                padding: 10px 20px;
            }

            .navbar-brand {
                font-size: 1.3rem;
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

        /* Animation for cards */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }

        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }
        .card:nth-child(5) { animation-delay: 0.5s; }
        .card:nth-child(6) { animation-delay: 0.6s; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light px-4" style="background-color: white;">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">🎨Art Paintings Recognition</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('predict') }}"><i class="fas fa-eye"></i> Nhận diện tranh</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paintings.select') }}"><i class="fas fa-image"></i> Thông tin tranh</a>
                </li>
                @if(Auth::check())
                <li class="nav-item">
                    <a href="{{ route('user.edit', Auth::user()->id) }}" class="nav-link">
                        <i class="fas fa-user"></i> Xin chào, {{ Auth::user()->username }}
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
<script>
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Add animation to cards when they come into view
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                }
            });
        }, { threshold: 0.1 });

        cards.forEach(card => {
            observer.observe(card);
        });
    });
</script>
</body>
</html>