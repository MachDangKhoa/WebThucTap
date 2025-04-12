<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Dashboard - API Usage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">🎨 Admin - API Usage</a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <!-- Thống kê số lượt gọi API theo thời gian -->
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('api_statistics') }}"><i class="fas fa-chart-line"></i>Statistics API</a>
                </li> -->
                <!-- Lấy top users gọi API nhiều nhất -->
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('api.top-users') }}"><i class="fas fa-users"></i> Top Users</a>
                </li> -->
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

        <div class="card">
            <div class="card-header">
                <h3 class="text-center">API Usage List</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Account ID</th>
                            <th>Endpoint</th>
                            <th>Call Count</th>
                            <th>Last Called At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($apiUsages as $apiUsage)
                            <tr>
                                <td>{{ $apiUsage->account_id }}</td>
                                <td>{{ $apiUsage->endpoint }}</td>
                                <td>{{ $apiUsage->call_count }}</td>
                                <td>{{ $apiUsage->last_called_at }}</td>
                                <td>
                                    <a href="{{ route('api.edit_api', $apiUsage->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('api.destroy_api', $apiUsage->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
