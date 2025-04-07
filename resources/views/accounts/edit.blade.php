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
        <h3>Edit Account</h3>
        
        <form action="{{ route('accounts.update', $account->id) }}" method="POST" id="updateForm">
            @csrf
            @method('PUT')

            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ $account->username }}" required>
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
