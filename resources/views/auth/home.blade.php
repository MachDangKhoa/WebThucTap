<!DOCTYPE html>
<html lang="en">
<head>
     <!-- Basic Meta Tags -->
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $config->description }}">
    <meta name="keywords" content="{{ $config->keywords  }}">
    <title>{{ $config->website_name}}</title>

    @if(!empty($config->favicon))
        <link rel="icon" href="{{ asset('storage/' . $config->favicon) }}" type="image/x-icon">
    @endif
    
    <!-- External Stylesheets -->
    <link href="https://assets.website-files.com/63bca273a4535eaa45430017/css/dailyart.webflow.8cebae8e7.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda&display=swap" rel="stylesheet">  


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

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo img {
            height: 50px; /* Adjust to your desired size */
            width: auto;
        }

        .logo a:hover {
            color: #333333; /* Hover color */
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
            height: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .art-info {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            transition: transform 0.3s ease;
        }

        .art-info:hover {
            transform: scale(1.1);
        }

        .art-title {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .art-artist {
            font-style: italic;
            font-size: 1rem;
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
            margin-bottom: 50px;
            font-size: 36px;
            color: #222;
        }

        /* Footer Section */
        footer {
            background-color: #fff;
            padding: 30px 20px;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        footer .footer-content {
            width: 90%;
            margin: 0 auto;
        }

        footer p {
            font-size: 1rem;
            color: #777;
        }

        footer .footer-links {
            margin-top: 20px;
        }

        footer .footer-links a {
            text-decoration: none;
            color: #3498db;
            font-weight: 700;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        footer .footer-links a:hover {
            color: #2980b9;
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

    <!-- Google Analytics (optional) -->
    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-XXXXXX-X"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-XXXXXX-X');
    </script> -->
    
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="header-container">
            <a class="logo" href="{{ route('home') }}">
                <img src="{{ asset('storage/uploads/logo.jpg') }}" alt="Art Painting" style="height: 60px; width: auto;">
            </a>
            <nav>
                <ul>
                    @auth
                        <!-- Hiển thị khi đã đăng nhập -->
                        @if(Auth::user()->username === 'admin')
                            <!-- Menu dành cho admin -->
                            <li><a href="{{ route('register') }}">Đăng ký</a></li>
                            <li><a href="{{ route('admin.dashboard') }}">Đăng nhập</a></li>
                        @else
                            <!-- Menu dành cho user thường -->
                            <li><a href="{{ route('register') }}">Đăng ký</a></li>
                            <li><a href="{{ route('dashboard') }}">Đăng nhập</a></li>
                        @endif
                     @else
                        <!-- <li><a href="#">Artworks</a></li>
                        <li><a href="#">Explore</a></li>
                        <li><a href="#">About</a></li> -->
                        <li><a href="{{ route('register') }}">Đăng ký</a></li>
                        <li><a href="{{ route('login.post') }}">Đăng nhập</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    <!-- Parallax Background Section -->
    <div class="parallax"></div>

    <!-- Main Content Section -->
    <main>
        <section class="intro">
            <h1>Khám phá nghệ thuật mới mỗi ngày</h1>
            <p>Duyệt qua hàng ngàn tác phẩm nghệ thuật và tìm hiểu về lịch sử, ý nghĩa và tác giả của chúng.</p>
            <a href="{{ route('login') }}" class="btn-explore">Khám phá nghệ thuật</a>
        </section>

        <section class="gallery">
            <h2>Nghệ sĩ nổi bật</h2>
                <div class="art-gallery">
                    <div class="art-piece">
                        <img src="{{ asset('storage/uploads/Vincent.jpg') }}" alt="Vincent van Gogh">
                        <div class="art-info" style="left: 0px">
                            <p class="art-title">Vincent van Gogh</p>
                            <p class="art-artist">Danh họa người Hà Lan nổi tiếng với các tác phẩm như "Starry Night" và "Sunflowers".</p>
                        </div>
                    </div>
                    <div class="art-piece">
                        <img src="{{ asset('storage/uploads/leonardo_da_vinci.jpg') }}" alt="Leonardo da Vinci">
                        <div class="art-info" style="left: 0px">
                            <p class="art-title">Leonardo da Vinci</p>
                            <p class="art-artist">Một trong những danh họa nổi tiếng nhất của thời kỳ Phục Hưng, nổi bật với các tác phẩm như "Mona Lisa" và "The Last Supper". </p>
                        </div>
                    </div>
                    <div class="art-piece">
                        <img src="{{ asset('storage/uploads/pablo_picasso.jpg') }}" alt="Pablo Picasso">
                        <div class="art-info" style="left: 0px">
                            <p class="art-title">Pablo Picasso</p>
                            <p class="art-artist">Một trong những nghệ sĩ vĩ đại nhất của thế kỷ 20, nổi bật với các phong cách như lập thể và các tác phẩm như "Guernica".</p>
                        </div>
                    </div>
                </div>

            <h2>Tác phẩm nghệ thuật nổi bật</h2>
            <div class="art-gallery">
                <div class="art-piece">
                    <img src="{{ asset('storage/uploads/starry_night.jpg') }}" alt="The Starry Night">
                    <div class="art-info">
                        <p class="art-title">The Starry Night</p>
                        <p class="art-artist">Vincent van Gogh</p>
                    </div>
                </div>
                <div class="art-piece">
                    <img src="{{ asset('storage/uploads/mona_lisa.jpg') }}" alt="Mona Lisa">
                    <div class="art-info">
                        <p class="art-title">Mona Lisa</p>
                        <p class="art-artist">Leonardo da Vinci</p>
                    </div>
                </div>
                <div class="art-piece">
                    <img src="{{ url('storage/uploads/soup.jpg') }}" alt="The Soup">
                    <div class="art-info">
                        <p class="art-title">The Soup</p>
                        <p class="art-artist">Pablo Picasso</p>
                    </div>
                </div>
                <div class="art-piece">
                    <img src="{{ asset('storage/uploads/Irises.jpg') }}" alt="Irises">
                    <div class="art-info">
                        <p class="art-title">Les Iris</p>
                        <p class="art-artist">Vincent van Gogh</p>
                    </div>
                </div>
                <!-- Additional Artwork Pieces with External Images -->
                <div class="art-piece">
                    <img src="{{ asset('storage/uploads/Adoration_of_the_magi.jpg') }}" alt="Adoration of the magi">
                    <div class="art-info">
                        <p class="art-title">Adoration of the magi</p>
                        <p class="art-artist">Leonardo da Vinci</p>
                    </div>
                </div>
                <div class="art-piece">
                    <img src="{{ url('storage/uploads/guernica.jpg') }}" alt="Guernica">
                    <div class="art-info">
                        <p class="art-title">Guernica</p>
                        <p class="art-artist">Pablo Picasso</p>
                    </div>
                </div>
            </div>

            <!-- Phong cách tranh nghệ thuật tiêu biểu -->
            <div class="container">
                <h2>Phong cách tranh nghệ thuật tiêu biểu</h2>
                
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

    <!-- Footer Section -->
    <footer>
        <div class="footer-content">
            <p>© 2025 Art Paintings. All Rights Reserved.</p>
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Contact</a>
            </div>
        </div>
    </footer>

    <script>
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
