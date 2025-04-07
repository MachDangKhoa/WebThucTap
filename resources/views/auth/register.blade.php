<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký thành viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f1f1f1;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background: linear-gradient(135deg,rgb(33, 152, 217),rgb(32, 134, 218));
        border-radius: 12px;
        padding: 15px 20px;  /* Giảm padding của container */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        color: white;
    }

    h2 {
        text-align: center;
        font-size: 22px;  /* Giảm font-size của tiêu đề */
        margin-bottom: 10px;
        font-weight: 700;
    }

    .form-control {
        border-radius: 8px;
        padding: 8px;  /* Giảm padding của input */
        margin-bottom: 12px;  /* Giảm margin giữa các input */
        font-size: 14px;  /* Giảm font-size */
        border: none;
    }

    .form-control:focus {
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        border-color: #007bff;
    }

    .btn-primary {
        width: 100%;
        padding: 10px;  /* Giảm padding của button */
        border-radius: 8px;
        background-color:rgb(12, 202, 47);
        border: none;
        font-size: 14px;  /* Giảm font-size của button */
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    label {
        font-weight: 600;
        color: #fff;
        font-size: 12px;  /* Giảm font-size của label */
        margin-bottom: 5px;
        display: block;
    }

    select.form-select {
        border-radius: 8px;
        padding: 8px;  /* Giảm padding của select */
        font-size: 14px;  /* Giảm font-size */
    }

    .d-grid {
        margin-top: 15px;  /* Giảm margin-top */
    }

    /* Mobile responsiveness */
    @media (max-width: 576px) {
        .container {
            padding: 15px;
        }

        h2 {
            font-size: 20px;
        }
    }
</style>


</head>
<body>

<div class="container">
    <h2>Đăng ký thành viên</h2>
    <form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-3">
        <label for="Username">Tên tài khoản:</label>
        <input type="text" name="username" class="form-control" placeholder="Nhập tên tài khoản" required>
        @error('username')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="Password">Mật khẩu:</label>
        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
        @error('password')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="pwd2">Xác nhận mật khẩu:</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu" required>
        @error('password_confirmation')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="GioiTinh">Giới tính:</label>
        <div>
            <input type="radio" name="gender" value="0" required> Nam
            <input type="radio" name="gender" value="1" required> Nữ
        </div>
    </div>

    <div class="mb-3">
        <label for="SDT">Số điện thoại:</label>
        <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" required>
    </div>

    <div class="mb-3">
        <label for="Email">Email:</label>
        <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
    </div>

    <div class="mb-3">
        <label for="Ngaysinh">Ngày sinh:</label>
        <input type="date" name="birth_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="Diachi">Nơi sinh sống:</label>
        <input type="text" name="address" class="form-control" placeholder="Nhập nơi sinh sống" required>
    </div>

    <button type="submit" class="btn btn-primary">Đăng ký</button>
</form>


</div>

</body>
</html>
