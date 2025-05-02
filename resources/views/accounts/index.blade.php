<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Dashboard - Manage Accounts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Navbar Style */
        .navbar {
        background: linear-gradient(90deg, #1f2a3f, #4c6e91);
        padding: 15px 30px;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
        font-weight: bold;
        color: white;
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">🎨 Admin Art Paintings</a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('accounts.index') }}"><i class="fas fa-users"></i> Manage Accounts</a>
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

    <div class="container mt-4">
        <!-- Hiển thị thông báo thành công hoặc lỗi -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Danh sách tài khoản -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Manage Accounts</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Genre</th>  <!-- Genre thay cho Gender -->
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                            <tr>
                                <td>{{ $account->username }}</td>
                                <td>{{ $account->gender == 1 ? 'Male' : 'Female' }}</td> <!-- Hiển thị giới tính -->
                                <td>{{ $account->email }}</td>
                                <td>{{ $account->phone }}</td>
                                <td>
                                    <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" style="display:inline;" id="deleteForm-{{ $account->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete({{ $account->id }})">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Hàm xác nhận xóa
        function confirmDelete(accountId) {
            const confirmation = confirm('Are you sure you want to delete this account?');

            if (confirmation) {
                // Nếu người dùng chọn OK, gửi form xóa
                document.getElementById('deleteForm-' + accountId).submit();
            } else {
                // Nếu người dùng chọn Cancel, không làm gì
                return false;
            }
        }
    </script>
</body>
</html>
