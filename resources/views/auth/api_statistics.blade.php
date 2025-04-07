
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>API Statistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-4">
        <h2>API Usage Statistics</h2>

        <form method="GET" action="{{ route('api_statistics') }}">
            <label for="time_period">Chọn thời gian:</label>
            <select name="time_period" id="time_period">
                <option value="day">Ngày</option>
                <option value="week">Tuần</option>
                <option value="month">Tháng</option>
            </select>
            <button type="submit" class="btn btn-primary">Lọc</button>
        </form>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Endpoint</th>
                    <th>Total Calls</th>
                </tr>
            </thead>
            <tbody>
                @foreach($apiUsageStats as $stat)
                    <tr>
                        <td>{{ $stat->date }}</td>
                        <td>{{ $stat->endpoint }}</td>
                        <td>{{ $stat->total_calls }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
