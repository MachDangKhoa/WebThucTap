<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập | Hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-light: #5e72e4;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --dark-color: #2b2d42;
            --light-color: #f8f9fa;
            --success-color: #4caf50;
            --error-color: #f44336;
            --warning-color: #ff9800;
            --bubble-opacity: 0.12;
            --bubble-color: rgba(67, 97, 238, 0.25); /* Tăng độ đậm */
            --bubble-highlight: rgba(255, 255, 255, 0.6);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', 'Roboto', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            position: relative;
            overflow: hidden;
            line-height: 1.6;
            color: var(--dark-color);
        }
        
        /* Hiệu ứng nền động - Bong bóng nâng cấp */
        .bubble-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .bubble {
            position: absolute;
            bottom: -150px;
            background-color: rgba(67, 97, 238, var(--bubble-opacity));
            border-radius: 50%;
            filter: blur(5px);
            animation: float-up 15s infinite ease-in;
            opacity: 0.8;
            transform: translateY(0) rotate(0deg);
            transition: all 0.5s ease;
        }
        
        /* Animation bong bóng */
        @keyframes float-up {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.7;
            }
            50% {
                opacity: 0.9;
            }
            100% {
                transform: translateY(-120vh) rotate(720deg);
                opacity: 0;
            }
        }
        
        /* Tạo các bong bóng với đặc điểm khác nhau */
        .bubble:nth-child(1) {
            width: 120px;
            height: 120px;
            left: 10%;
            animation-duration: 22s;
            animation-delay: 0s;
        }
        
        .bubble:nth-child(2) {
            width: 60px;
            height: 60px;
            left: 25%;
            animation-duration: 18s;
            animation-delay: 2s;
        }
        
        .bubble:nth-child(3) {
            width: 90px;
            height: 90px;
            left: 40%;
            animation-duration: 25s;
            animation-delay: 1s;
            --bubble-opacity: 0.15;
        }
        
        .bubble:nth-child(4) {
            width: 150px;
            height: 150px;
            left: 70%;
            animation-duration: 30s;
            animation-delay: 3s;
        }
        
        .bubble:nth-child(5) {
            width: 80px;
            height: 80px;
            left: 85%;
            animation-duration: 20s;
            animation-delay: 0.5s;
            --bubble-opacity: 0.08;
        }
        
        .bubble:nth-child(6) {
            width: 200px;
            height: 200px;
            left: 50%;
            animation-duration: 35s;
            animation-delay: 4s;
        }
        
        .bubble:nth-child(7) {
            width: 50px;
            height: 50px;
            left: 30%;
            animation-duration: 15s;
            animation-delay: 1.5s;
        }
        
        .bubble:nth-child(8) {
            width: 100px;
            height: 100px;
            left: 65%;
            animation-duration: 28s;
            animation-delay: 2.5s;
            --bubble-opacity: 0.1;
        }
        
        /* Hiệu ứng khi tương tác với bong bóng */
        .bubble:hover {
            filter: blur(5px) brightness(1.2);
            box-shadow: 0 0 30px rgba(67, 97, 238, 0.3);
            animation-play-state: paused;
            opacity: 0.95;
        }
        
        /* Container đăng nhập */
        .login-container {
            background: rgba(255, 255, 255, 0.97);
            padding: 2.5rem;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
            width: 420px;
            text-align: center;
            position: relative;
            overflow: hidden;
            transform: translateY(20px);
            opacity: 0;
            animation: fadeInUp 0.6s ease-out 0.2s forwards;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            transition: all 0.3s ease;
        }
        
        .login-container:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        @keyframes fadeInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        /* Thanh gradient trên cùng */
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            transition: all 0.3s ease;
        }
        
        .login-container:hover::before {
            height: 8px;
        }
        
        /* Tiêu đề */
        .login-container h2 {
            margin: 1.5rem 0 2rem;
            font-size: 1.8rem;
            color: var(--dark-color);
            font-weight: 700;
            position: relative;
            padding-bottom: 1rem;
        }
        
        .login-container h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        
        .login-container:hover h2::after {
            width: 100px;
        }
        
        /* Form controls */
        .form-control {
            margin-bottom: 1.25rem;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
        
        /* Nút đăng nhập */
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.4s ease;
            margin-top: 0.5rem;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
            background: linear-gradient(135deg, var(--primary-light), var(--secondary-color));
        }
        
        .btn-login:active {
            transform: translateY(-1px);
        }
        
        .btn-login::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.15);
            transform: rotate(30deg);
            transition: all 0.6s ease;
        }
        
        .btn-login:hover::after {
            left: 100%;
        }
        
        /* Nút home */
        .btn-home {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: transparent;
            border: none;
            color: var(--dark-color);
            font-size: 1.25rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .btn-home:hover {
            color: var(--primary-color);
            background: rgba(67, 97, 238, 0.1);
            transform: scale(1.15);
        }
        
        /* Nhóm input */
        .input-group {
            position: relative;
            margin-bottom: 1.25rem;
        }
        
        .input-group-text {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            background: transparent;
            border: none;
            z-index: 10;
            color: var(--dark-color);
            font-size: 1rem;
            width: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .input-group .form-control {
            padding-left: 3rem;
            position: relative;
        }
        
        /* Nút hiển thị mật khẩu */
        #toggle-password {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--dark-color);
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        #toggle-password:hover {
            color: var(--primary-color);
            background: rgba(67, 97, 238, 0.1);
            transform: translateY(-50%) scale(1.15);
        }
        
        /* Thông báo */
        .alert {
            margin: 1rem 0;
            border-radius: 10px;
            padding: 0.8rem 1rem;
            text-align: left;
            border: none;
            position: relative;
            overflow: hidden;
            font-size: 0.9rem;
        }
        
        .alert::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 5px;
            height: 100%;
        }
        
        .alert-success {
            background-color: rgba(76, 175, 80, 0.15);
            color: #2e7d32;
        }
        
        .alert-success::before {
            background-color: var(--success-color);
        }
        
        .alert-danger {
            background-color: rgba(244, 67, 54, 0.15);
            color: #c62828;
        }
        
        .alert-danger::before {
            background-color: var(--error-color);
        }
        
        .alert-warning {
            background-color: rgba(255, 152, 0, 0.15);
            color: #e65100;
        }
        
        .alert-warning::before {
            background-color: var(--warning-color);
        }
        
        .alert ul {
            margin-bottom: 0;
            padding-left: 1.25rem;
        }
        
        .alert i {
            margin-right: 0.5rem;
        }
        
        /* Footer text */
        .footer-text {
            margin: 1.5rem 0 0;
            font-size: 0.875rem;
            color: #666;
        }
        
        .footer-text a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .footer-text a:hover {
            color: var(--secondary-color);
        }
        
        .footer-text a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--secondary-color);
            transition: width 0.3s ease;
        }
        
        .footer-text a:hover::after {
            width: 100%;
        }
        
        /* Responsive design */
        @media (max-width: 480px) {
            .login-container {
                width: 90%;
                padding: 1.75rem;
                margin: 0 1rem;
            }
            
            .login-container h2 {
                font-size: 1.5rem;
                margin: 1rem 0 1.5rem;
            }
            
            .btn-home {
                top: 0.75rem;
                left: 0.75rem;
                font-size: 1.1rem;
                width: 2.2rem;
                height: 2.2rem;
            }
            
            .form-control {
                padding: 0.65rem 0.9rem;
                font-size: 0.9rem;
            }
            
            .btn-login {
                padding: 0.7rem;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <!-- Nền bong bóng động -->
    <div class="bubble-bg">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <div class="login-container">
        <!-- Nút Home -->
        <a href="{{ route('home') }}" class="btn-home" title="Trang chủ">
            <i class="fas fa-home"></i>
        </a>

        <h2><i class="fas fa-sign-in-alt me-2"></i>Đăng nhập</h2>

        <!-- Hiển thị thông báo -->
        @if(session('message'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>{{ session('message') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>{{ session('warning') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" id="loginForm">
            @csrf
            <!-- Username -->
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input id="username" type="text" name="username" class="form-control" placeholder="Tên tài khoản" required value="{{ old('username') }}" autocomplete="username">
            </div>

            <!-- Password -->
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input id="password" type="password" name="password" class="form-control" placeholder="Mật khẩu" required autocomplete="current-password">
                <button type="button" id="toggle-password" class="btn" aria-label="Hiển thị mật khẩu">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <!-- Remember me -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                </div>
            </div>

            <button type="submit" class="btn btn-login" id="loginButton">
                <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
            </button>
            
            <p class="footer-text">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
        </form>
    </div>

    <script>
        // Tạo thêm bong bóng động bằng JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            const bubbleBg = document.querySelector('.bubble-bg');
            
            // Tạo thêm bong bóng ngẫu nhiên
            for (let i = 0; i < 6; i++) {
                const bubble = document.createElement('div');
                bubble.classList.add('bubble');
                
                // Kích thước ngẫu nhiên
                const size = Math.random() * 120 + 30;
                bubble.style.width = `${size}px`;
                bubble.style.height = `${size}px`;
                
                // Vị trí ngẫu nhiên
                bubble.style.left = `${Math.random() * 100}%`;
                
                // Thời gian animation ngẫu nhiên
                const duration = Math.random() * 20 + 15;
                bubble.style.animationDuration = `${duration}s`;
                bubble.style.animationDelay = `${Math.random() * 8}s`;
                
                // Độ mờ ngẫu nhiên
                bubble.style.filter = `blur(${Math.random() * 4 + 1}px)`;
                
                // Độ trong suốt ngẫu nhiên
                bubble.style.setProperty('--bubble-opacity', Math.random() * 0.1 + 0.05);
                
                // Thêm vào nền
                bubbleBg.appendChild(bubble);
            }
            
            // Hiệu ứng khi tương tác với bong bóng
            document.querySelectorAll('.bubble').forEach(bubble => {
                bubble.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.15)';
                    this.style.boxShadow = '0 0 40px rgba(67, 97, 238, 0.4)';
                    this.style.opacity = '0.95';
                });
                
                bubble.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                    this.style.opacity = '';
                });
            });
        });

        // Toggle password visibility
        const togglePassword = document.getElementById("toggle-password");
        const passwordField = document.getElementById("password");
        
        togglePassword.addEventListener("click", function() {
            const icon = this.querySelector("i");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
                this.setAttribute("aria-label", "Ẩn mật khẩu");
            } else {
                passwordField.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
                this.setAttribute("aria-label", "Hiển thị mật khẩu");
            }
        });
        
        // Hiệu ứng khi focus vào input
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('.input-group-text').style.color = 'var(--primary-color)';
                this.parentElement.querySelector('.input-group-text').style.transform = 'scale(1.1)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.querySelector('.input-group-text').style.color = 'var(--dark-color)';
                this.parentElement.querySelector('.input-group-text').style.transform = '';
            });
        });
        
        // Hiệu ứng loading khi submit form
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        
        if (loginForm) {
            loginForm.addEventListener('submit', function() {
                loginButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Đang đăng nhập...';
                loginButton.disabled = true;
            });
        }
        
        // Tự động focus vào trường username
        window.onload = function() {
            const usernameField = document.getElementById('username');
            if (usernameField) {
                usernameField.focus();
            }
        };
    </script>
</body>
</html>