<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa tài khoản - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; display: none; }
        }
        .fade-out {
            animation: fadeOut 1.5s forwards;
        }
        .main-content {
            flex-grow: 1;
            min-width: 0;
        }
        .art-bg {
            background: linear-gradient(135deg, rgba(30, 39, 46, 1) 0%, rgba(58, 85, 103, 1) 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .pulse:hover {
            animation: pulse 1.5s infinite;
        }
        .form-input {
            transition: all 0.3s ease;
            border: 1px solid #d1d5db;
        }
        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans leading-normal tracking-normal">

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
        <div class="main-content p-6 md:p-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-green-500">
                        Chỉnh sửa tài khoản
                    </span>
                </h1>
                <div class="text-sm text-gray-500 bg-white p-3 rounded-lg shadow-sm">
                    <i class="fas fa-calendar-alt mr-2 text-blue-500"></i> 
                    <span class="font-medium">{{ now()->format('d/m/Y') }}</span>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                    <div>
                        <p class="font-medium">Thành công!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                        <div>
                            <p class="font-medium">Có lỗi xảy ra!</p>
                            <ul class="list-disc list-inside mt-1 text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form chỉnh sửa -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover transition duration-300">
                <div class="p-6">
                    <form action="{{ route('user.update', $account->id) }}" method="POST" id="updateForm">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Username -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                <input type="text" name="username" class="w-full px-4 py-3 form-input rounded-lg" 
                                       value="{{ $account->username }}" readonly>
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password"
                                           class="w-full px-4 py-3 form-input rounded-lg" 
                                           placeholder="Để trống nếu không muốn thay đổi">
                                    <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 toggle-password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Giới tính</label>
                                <select name="gender" class="w-full px-4 py-3 form-input rounded-lg">
                                    <option value="0" {{ $account->gender == 0 ? 'selected' : '' }}>Nam</option>
                                    <option value="1" {{ $account->gender == 1 ? 'selected' : '' }}>Nữ</option>
                                </select>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" class="w-full px-4 py-3 form-input rounded-lg" 
                                       value="{{ $account->email }}" required>
                            </div>

                            <!-- Phone -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                                <input type="text" name="phone" class="w-full px-4 py-3 form-input rounded-lg" 
                                       value="{{ $account->phone }}">
                            </div>

                            <!-- Birth Date -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ngày sinh</label>
                                <input type="date" name="birth_date" class="w-full px-4 py-3 form-input rounded-lg" 
                                       value="{{ $account->birth_date }}">
                            </div>

                            <!-- Address -->
                            <div class="form-group md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                                <textarea name="address" rows="3" class="w-full px-4 py-3 form-input rounded-lg">{{ $account->address }}</textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end space-x-4 border-t pt-6">
                            <a href="{{ route('dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg transition duration-300 flex items-center">
                                <i class="fas fa-arrow-left mr-2"></i> Quay lại
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-300 flex items-center">
                                <i class="fas fa-save mr-2"></i> Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        $(document).on('click', '.toggle-password', function() {
            const input = $(this).siblings('input');
            const icon = $(this).find('i');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Xử lý xác nhận trước khi cập nhật
        $('#updateForm').on('submit', function(e) {
            if(!confirm('Bạn có chắc chắn muốn cập nhật thông tin tài khoản này?')) {
                e.preventDefault();
            }
        });

        // Xử lý logout
        $('#logout').on('submit', function(event) {
            event.preventDefault();
            if(confirm('Bạn có chắc chắn muốn đăng xuất?')) {
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function() {
                        window.location.href = "{{ route('home') }}";
                    },
                    error: function() {
                        alert('Đăng xuất thất bại. Vui lòng thử lại.');
                    }
                });
            }
        });
    </script>
</body>
</html>