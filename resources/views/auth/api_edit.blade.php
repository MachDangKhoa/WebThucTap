<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-4">
        <!-- Hiển thị thông báo thành công hoặc lỗi -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>Edit API Usage - {{ $apiUsage->endpoint }}</h3>
            </div>
            <div class="card-body">
                <!-- Form chỉnh sửa API -->
                <form action="{{ route('api.update_api', $apiUsage->id) }}" method="POST" id="updateForm">
                    @csrf
                    @method('PUT') <!-- Use POST method for update -->

                    <div class="mb-3">
                        <label for="endpoint" class="form-label">API Endpoint</label>
                        <input type="text" class="form-control" id="endpoint" name="endpoint" value="{{ $apiUsage->endpoint }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="call_count" class="form-label">Call Count</label>
                        <input type="number" class="form-control" id="call_count" name="call_count" value="{{ $apiUsage->call_count }}" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update API Usage</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
