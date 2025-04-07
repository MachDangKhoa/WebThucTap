<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Đăng nhập</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    
    <style>
        body {
            background-image: url('https://inkythuatso.com/uploads/thumbnails/800/2022/07/tranh-phong-canh-dong-que-viet-nam-dep-nhat-4-inkythuatso-20-11-07-41.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-custom {
            width: 100%;
        }
        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #ccc;
        }
        .alert {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
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

            <button type="submit" class="btn btn-primary btn-custom">Đăng nhập</button>
            <p class="mt-3">Chưa có tài khoản? <a href="{{ route('register') }}" class="text-primary">Đăng ký</a></p>
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
