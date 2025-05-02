<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">  

    <style>
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

        /* Mobile adjustments */
        @media (max-width: 768px) {           
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
        }
    </style>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light px-4" style="background-color: white;">
        <a class="navbar-brand" href="{{ route('dashboard') }}">🎨Art Paintings Recognition</a>
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
                <a href="{{ route('account.edit', Auth::user()->id) }}" class="nav-link">
                    Xin chào, {{ Auth::user()->username }}
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
    <div class="container mt-4">
        <h3 class="text-center">Account Infomation</h3>
        
        <form action="{{ route('accounts.update', $account->id) }}" method="POST" id="updateForm">
            @csrf
            @method('PUT')

            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ $account->username }}" disabled>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank if you don't want to change">
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">Show</button>
                </div>
            </div>

            <!-- Gender (Male/Female) -->
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="1" {{ $account->gender == 0 ? 'selected' : '' }}>Male</option>
                    <option value="0" {{ $account->gender == 1 ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $account->email }}" required>
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $account->phone }}">
            </div>

            <!-- Birth Date -->
            <div class="mb-3">
                <label for="birth_date" class="form-label">Birth Date</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ $account->birth_date }}">
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address">{{ $account->address }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary" id="updateButton">Update</button>
        </form>
    </div>

    <script>
        // Lấy phần tử password và nút Show/Hide
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');

        // Lắng nghe sự kiện click vào nút Show/Hide
        togglePasswordButton.addEventListener('click', function() {
            // Nếu mật khẩu đang ở dạng ẩn, chuyển thành hiển thị
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordButton.textContent = 'Hide';  // Đổi nút thành "Hide"
            } else {
                passwordInput.type = 'password';
                togglePasswordButton.textContent = 'Show';  // Đổi nút thành "Show"
            }
        });

        // Thêm sự kiện xác nhận trước khi gửi form
        const updateButton = document.getElementById('updateButton');
        const updateForm = document.getElementById('updateForm');

        updateButton.addEventListener('click', function(event) {
            // Hiển thị hộp thoại xác nhận
            const confirmation = confirm('Are you sure you want to update this account?');
            
            // Nếu người dùng chọn "OK", gửi form
            if (!confirmation) {
                event.preventDefault();  // Ngừng gửi form nếu người dùng chọn "Cancel"
            }
        });
    </script>

    <!-- Thông báo thành công -->
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
</body>
</html>
