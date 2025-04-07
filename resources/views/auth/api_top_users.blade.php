
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Top API Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-4">
        <h2>Top API Users</h2>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Account ID</th>
                    <th>Total Calls</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topUsers as $user)
                    <tr>
                        <td>{{ $user->account_id }}</td>
                        <td>{{ $user->total_calls }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
