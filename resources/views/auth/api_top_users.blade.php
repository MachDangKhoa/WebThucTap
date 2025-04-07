<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Dashboard - Top Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">🎨 Admin Dashboard</a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('api_statistics') }}"><i class="fas fa-chart-line"></i> API Usage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('api.top-users') }}"><i class="fas fa-users"></i> Top Users</a>
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
        <!-- Thông báo thành công hoặc lỗi -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Top Users Table -->
        <div class="card">
            <div class="card-header">
                <h3>Top Users - API Usage</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Account ID</th>
                            <th>Total API Calls</th>
                        </tr>
                    </thead>
                    <tbody id="top-users-table">
                        <!-- Dữ liệu người dùng gọi API nhiều nhất sẽ được chèn vào đây -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Hàm gọi API và hiển thị top users
        async function fetchTopUsers() {
            const response = await fetch('/api/top-users');
            const data = await response.json();

            const tableBody = document.getElementById('top-users-table');
            tableBody.innerHTML = ''; // Clear previous data

            data.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `<td>${user.account_id}</td><td>${user.total_calls}</td>`;
                tableBody.appendChild(row);
            });
        }

        // Gọi API lần đầu để tải dữ liệu top users
        fetchTopUsers();
    </script>

</body>
</html>
