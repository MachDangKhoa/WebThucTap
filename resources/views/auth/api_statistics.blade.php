<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Dashboard - API Usage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <a class="nav-link" href="{{ route('api.top-users') }}"><i class="fas fa-users"></i> Top Users</a>
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

        <!-- API Usage Statistics -->
        <div class="card">
            <div class="card-header">
                <h3>API Usage Statistics</h3>
                <select id="time-period" class="form-select" style="width: 200px; display: inline-block;">
                    <option value="day">Ngày</option>
                    <option value="week">Tuần</option>
                    <option value="month">Tháng</option>
                </select>
            </div>
            <div class="card-body">
                <canvas id="apiUsageChart"></canvas>
            </div>
        </div>

        <!-- Bảng thống kê chi tiết -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>API Usage Details</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Endpoint</th>
                            <th>Total Calls</th>
                        </tr>
                    </thead>
                    <tbody id="apiUsageTableBody">
                        <!-- Dữ liệu sẽ được thêm vào đây bằng JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Hàm gọi API và hiển thị thống kê
        async function fetchApiUsageData(timePeriod = 'day') {
            const response = await fetch(`/api/usage?time_period=${timePeriod}`);
            const data = await response.json();

            // Cập nhật biểu đồ
            const ctx = document.getElementById('apiUsageChart').getContext('2d');
            const apiUsageChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(item => item.date), // Ngày
                    datasets: [{
                        label: 'Total API Calls',
                        data: data.map(item => item.total_calls), // Số lần gọi API
                        borderColor: '#1abc9c',
                        fill: false
                    }]
                }
            });

            // Cập nhật bảng dữ liệu
            const tableBody = document.getElementById('apiUsageTableBody');
            tableBody.innerHTML = ''; // Clear previous data

            data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `<td>${item.date}</td><td>${item.endpoint}</td><td>${item.total_calls}</td>`;
                tableBody.appendChild(row);
            });
        }

        // Lắng nghe thay đổi khoảng thời gian từ dropdown
        document.getElementById('time-period').addEventListener('change', (e) => {
            const timePeriod = e.target.value;
            fetchApiUsageData(timePeriod);
        });

        // Gọi API lần đầu để tải dữ liệu cho ngày
        fetchApiUsageData('day');
    </script>

</body>
</html>
