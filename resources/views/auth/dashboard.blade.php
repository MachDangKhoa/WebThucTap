<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $config->description }}">
    <meta name="keywords" content="{{ $config->keywords  }}">
    <title>{{ $config->website_name}}</title>

    @if(!empty($config->favicon))
        <link rel="icon" href="{{ asset('storage/' . $config->favicon) }}" type="image/x-icon">
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        /* General Styles */
        body {
            font-family: 'Bodoni Moda', cursive;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            overflow-x: hidden;
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

        /* Main Content Section */
        main {
            padding: 50px 20px;
            width: 90%;
            margin: 0 auto;
        }

        /* Intro Section */
        .intro {
            text-align: center;
            margin-bottom: 50px;
            opacity: 0;
            animation: fadeIn 2s forwards;
        }

        .intro h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            transition: transform 0.3s ease;
        }

        .intro h1:hover {
            transform: scale(1.05);
        }

        .intro p {
            font-size: 1.1rem;
            color: #555;
            margin: 10px 0;
        }

        button {
            padding: 12px 30px;
            font-size: 1rem;
            color: #fff;
            background-color: #3498db;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        /* Gallery Section */
        .gallery {
            text-align: center;
            margin-bottom: 50px;
        }

        .gallery h2 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            opacity: 0;
            animation: fadeIn 2s 1s forwards;
        }

        .art-gallery {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            flex-wrap: wrap;
        }

        .art-piece {
            position: relative;
            width: 30%;
            transition: transform 0.3s ease, opacity 0.3s ease;
            margin-bottom: 30px;
            opacity: 0;
            animation: fadeIn 2s 1s forwards;
            transform: translateY(50px);
            display: flex;
            flex-direction: column;
        }

        .art-piece.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .art-piece:hover {
            transform: scale(1.1);
        }

        .art-piece img {
            width: 100%;
            height: 100%; /* Cố định chiều cao */
            object-fit: cover; /* Đảm bảo ảnh không bị méo */
            border-radius: 10px 10px 0 0; /* Bo tròn góc trên */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .art-info-container {
            margin-top: 15px;
            text-align: left;
            padding: 15px;
            background-color: black;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            text-align: center;
        }
        .art-info-container:hover {
            transform: scale(1.1);
        }

        .art-title {
            font-weight: 700;
            font-size: 1.2rem;
            color: white;
            margin-bottom: 5px;
            
        }
        .art-title:hover {
            transform: scale(1.1);
        }

        .art-artist {
            font-style: italic;
            font-size: 1rem;
            color: white;
            transition: transform 0.3s ease;
        }
        .art-artist:hover {
            transform: scale(1.1);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .art-styles {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            font-family: 'Bodoni Moda', serif;
        }

        .art-style {
            position: relative;
            font-size: 35px;
            font-weight: 600;
            cursor: pointer;
            color: #333;
            padding: 10px 15px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .art-style:hover {
            color: #000;
            transform: translateY(-3px);
            transition: all 0.3s ease;
            font-weight: bold;
            text-shadow: 0 0 1px currentColor;
            
        }

        .art-image-container {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            width: 250px;
            height: 180px;
            opacity: 0;
            pointer-events: none;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            z-index: 100;
            margin-top: 15px;
        }

        .art-image {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .art-style:hover .art-image-container {
            opacity: 0.6;
            transform: translateX(-50%) translateY(-20%);
        }
        
        h1 {
            text-align: center;
            font-family: Roslindale Condensed, Georgia, sans-serif;
            margin-bottom: 50px;
            font-size: 36px;
            color: #222;
            font-style: italic;
        }
        .btn-explore {
            display: inline-block;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: background 0.3s, transform 0.3s;
        }

        .btn-explore:hover {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            transform: translateY(-3px);
        }
        /* Scroll Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Scrolling Animations */
        .scroll-animation {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .scroll-animation.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Mobile adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
                top: 80px;
            }
            .main-content {
                margin-left: 0;
            }
            .toggle-btn {
                display: block;
                z-index: 1001;
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
            
            .art-piece {
                width: 100%;
            }
        }

        /* Parallax Effect for Background Image */
        .parallax {
            background-image: url('https://i.pinimg.com/736x/2c/0c/bf/2c0cbfbd011cfeaa673231810f26453a.jpg');
            height: 400px;
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            animation: parallaxEffect 6s infinite alternate;
        }

        @keyframes parallaxEffect {
            0% {
                background-position: 50% 50%;
            }
            100% {
                background-position: 50% 60%;
            }
        }
    </style>
</head>
<body>
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
<div class="parallax"></div>
<!-- Main Content Section -->
<main>
    <section class="intro">
        <h1>Discover New Art Every Day</h1>
        <p>Browse thousands of artworks and learn about their history, meaning, and creators.</p>
        <a href="{{ route('predict') }}" class="btn-explore">Identification Paintings</a>
    </section>

    <section class="gallery">
        <h2>Paintings Datasets</h2>
            <div class="art-gallery">
            @foreach($paintingDb as $paintingDb)
                <div class="art-piece">
                    <img src="{{ $paintingDb->img_url_db}}">
                    <div class="art-info-container">
                        <p class="art-title">{{$paintingDb->painting_title}}</p>
                        <p class="art-artist">
                            <strong>Họa sĩ:</strong> {{$paintingDb->artist_db}}<br>
                            <strong>Phong cách:</strong> {{$paintingDb->style_db }}<br>
                            <strong>Độ tương đồng:</strong> {{ $paintingDb->similarity }}<br>
                            <strong>Nhiếp ảnh gia:</strong> {{ $paintingDb->photographer }}<br>
                            <strong>Mô tả:</strong> {{ $paintingDb->description ?? 'Không có' }}<br>
                        </p>
                    </div>
                </div>
            @endforeach
            </div>

        <h2>Paintings Google</h2>
            <div class="art-gallery">
            @foreach($paintingGoogle as $painting)
                <div class="art-piece">
                    <img src="{{ $painting->img_url_gg}}">
                    <div class="art-info-container">
                        <p class="art-title">{{$painting->title_gg}}</p>
                        <p class="art-artist">
                            <strong>Họa sĩ:</strong> {{$painting->artist_gg}}<br>
                            <strong>Phong cách:</strong> {{$painting->style_gg }}<br>
                            <strong>Thể loại:</strong> {{ $painting->genre_gg }}<br>
                            <strong>Năm:</strong> {{ $painting->year_gg }}<br>
                            <strong>Mô tả:</strong> {{ $painting->description_gg ?? 'Không có' }}<br>
                            <strong>Đặc điểm nghệ thuật:</strong> {{ $painting->artistic_features_gg }}<br>
                            <strong>Thông tin bổ sung:</strong> {{ $painting->additional_info_gg }}<br>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

        <!-- Phong cách tranh nghệ thuật tiêu biểu -->
        <div class="container">
            <h2>Explore Art Movements</h2>
            
            <div class="art-styles">
                <!-- Ukiyo-e - Màu đỏ cam năng động -->
                <div class="art-style" data-image="{{ asset('storage/uploads/itsukushima-in-aki-province.jpg') }}" style="color: #FF6B6B;">
                    Ukiyo-e
                    <div class="art-image-container">
                        <div class="art-image"></div>
                    </div>
                </div>
                
                <!-- Renaissance - Xanh dương điện -->
                <div class="art-style" data-image="{{ asset('storage/uploads/mona_lisa_1.jpg') }}" style="color: #48DBFB;">
                    Renaissance
                    <div class="art-image-container">
                        <div class="art-image"></div>
                    </div>
                </div>
                
                <!-- Realism - Màu vàng mật ong -->
                <div class="art-style" data-image="{{ asset('storage/uploads/angelus.jpg') }}" style="color: #FFD166;">
                    Realism
                    <div class="art-image-container">
                        <div class="art-image"></div>
                    </div>
                </div>
                
                <!-- Post Impressionism - Tím hoa cà -->
                <div class="art-style" data-image="{{ asset('storage/uploads/starry_night.jpg') }}" style="color: #A78BFA;">
                    Post Impressionism
                    <div class="art-image-container">
                        <div class="art-image"></div>
                    </div>
                </div>
                
                <!-- Impressionism - Xanh lá tươi -->
                <div class="art-style" data-image="{{ asset('storage/uploads/8ajI26cy00I0kgbpYoVyo6H0d7nB7Ilp9A73uloK.jpg') }}" style="color: #4ADE80;">
                    Impressionism
                    <div class="art-image-container">
                        <div class="art-image"></div>
                    </div>
                </div>
                
                <!-- Romanticism - Hồng phấn -->
                <div class="art-style" data-image="{{ url('storage/uploads/romanticism.jpg') }}" style="color: #F9A8D4;">
                    Romanticism
                    <div class="art-image-container">
                        <div class="art-image"></div>
                    </div>
                </div>
                
                <!-- Expressionism - Cam cháy -->
                <div class="art-style" data-image="{{ url('storage/uploads/the_scream.jpg') }}" style="color: #FB923C;">
                    Expressionism
                    <div class="art-image-container">
                        <div class="art-image"></div>
                    </div>
                </div>
                
                <!-- Cubism - Xanh ngọc sáng -->
                <div class="art-style" data-image="{{ url('storage/uploads/guernica.jpg') }}" style="color: #06B6D4;">
                    Cubism
                    <div class="art-image-container">
                        <div class="art-image"></div>
                    </div>
                </div>
                
                <!-- Rococo - Tím lavender -->
                <div class="art-style" data-image="{{ url('storage/uploads/the_swing.jpg') }}" style="color: #C084FC;">
                    Rococo
                    <div class="art-image-container">
                        <div class="art-image"></div>
                    </div>
                </div>
                
                <!-- Baroque - Xanh coban -->
                <div class="art-style" data-image="{{ url('storage/uploads/The_Raising_of_the_Cross.jpg') }}" style="color: #2563EB;">
                    Baroque
                    <div class="art-image-container">
                        <div class="art-image"></div>
                    </div>
                </div>
                
                <!-- Fauvism - Đỏ rực -->
                <div class="art-style" data-image="{{ url('storage/uploads/charing-cross-bridge.jpg') }}" style="color: #EF4444;">
                    Fauvism
                    <div class="art-image-container">
                        <div class="art-image"></div>
                    </div>
                </div>
                
                <!-- ... and much more - Xám bạc -->
                <div class="art-style" data-image="{{ url('storage/uploads/madonna-and-child-with-saints.jpg') }}" style="color:rgb(135, 135, 135);">
                    ... and much more
                    <div class="art-image-container">
                        <div class="art-image"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Scroll animation
    window.addEventListener('scroll', function() {
        let scrollElements = document.querySelectorAll('.scroll-animation');
        scrollElements.forEach(function(el) {
            if (isElementInViewport(el)) {
                el.classList.add('visible');
            }
        });
    });

    function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return rect.top <= window.innerHeight && rect.bottom >= 0;
    }
    // JavaScript to handle dynamic effects
    document.querySelectorAll('.art-piece').forEach((item) => {
        item.addEventListener('mouseover', () => {
            item.style.transform = 'scale(1.1)';
        });
        item.addEventListener('mouseout', () => {
            item.style.transform = 'scale(1)';
        });
    });

    // Scroll effect to reveal images when they are in view
    window.addEventListener('scroll', () => {
        const artPieces = document.querySelectorAll('.art-piece');
        artPieces.forEach(piece => {
            if (isInViewport(piece)) {
                piece.classList.add('visible');
            }
        });
    });

    // Check if element is in viewport
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return rect.top >= 0 && rect.left >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && rect.right <= (window.innerWidth || document.documentElement.clientWidth);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const artStyles = document.querySelectorAll('.art-style');
        
        artStyles.forEach(style => {
            const imageUrl = style.getAttribute('data-image');
            const imageElement = style.querySelector('.art-image');
            
            // Set image background
            imageElement.style.backgroundImage = `url(${imageUrl})`;
            
            // Position the image on hover
            style.addEventListener('mouseenter', function(e) {
                const rect = style.getBoundingClientRect();
                
                // Position image to the right if there's space, otherwise to the left
                if (rect.right + 320 < window.innerWidth) {
                    imageElement.style.left = '100%';
                    imageElement.style.right = 'auto';
                } else {
                    imageElement.style.right = '100%';
                    imageElement.style.left = 'auto';
                }
                
                // Position vertically centered relative to the text
                imageElement.style.top = '50%';
                imageElement.style.transform = 'translateY(-50%)';
            });
        });
    });
</script>
</body>
</html>