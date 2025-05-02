<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <style>
        body {
            background-image: url('https://i.pinimg.com/736x/06/c8/e9/06c8e9198006cc2f00f3878fa6e8c341.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Roboto', sans-serif;
            overflow: hidden;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.85);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            backdrop-filter: blur(10px);
            transform: translateY(100px);
            opacity: 0;
            animation: slideUp 0.6s ease-out forwards;
            position: relative;
        }
        @keyframes slideUp {
            0% {
                transform: translateY(100px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
            font-weight: 600;
        }
        .form-control {
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-shadow: none;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .btn-custom {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            transform: scale(1.02);
        }
        .btn-home {
            position: absolute;
            top: 15px;
            left: 15px;
            background: transparent;
            border: none;
            color: #333;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }
        .btn-home:hover {
            color: #007bff;
            transform: scale(1.1);
        }
        .input-group-text {
            background: #f8f9fa;
            border-radius: 8px 0 0 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .input-group .form-control {
            border-radius: 0 8px 8px 0;
        }
        .alert {
            margin-top: 10px;
            border-radius: 8px;
            padding: 10px;
            text-align: left;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        p {
            margin-top: 15px;
            font-size: 14px;
        }
        p a {
            color: #007bff;
            text-decoration: none;
        }
        p a:hover {
            text-decoration: underline;
        }

        /* Chuyển động cho các icon */
        .input-group-text i {
            transition: transform 0.3s ease;
        }
        .input-group-text:hover i {
            transform: rotate(360deg);
        }
        
        /* Nút hiển thị mật khẩu */
        #toggle-password {
            border-radius: 0 8px 8px 0;
            border-left: none;
            transition: all 0.3s ease;
        }
        #toggle-password:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Nút Home -->
        <a href="{{ route('home') }}" class="btn-home" title="Trang chủ">
            <i class="fas fa-home"></i>
        </a>

        <h2>Đăng nhập</h2>

        <!-- Display any success or error messages -->
        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <!-- Username -->
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input id="username" type="text" name="username" class="form-control" placeholder="Tên tài khoản" required value="{{ old('username') }}">
            </div>

            <!-- Password -->
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input id="password" type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                <button type="button" id="toggle-password" class="btn btn-light">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <button type="submit" class="btn btn-custom">Đăng nhập</button>
            <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a></p>
        </form>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById("toggle-password").addEventListener("click", function() {
            const passwordField = document.getElementById("password");
            const icon = this.querySelector("i");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    </script>
</body>
</html>