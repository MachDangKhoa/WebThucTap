<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký thành viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3a0ca3;
        --accent-color: #4cc9f0;
        --success-color: #2ecc71;
        --text-light: #f8f9fa;
        --text-dark: #212529;
    }
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        color: var(--text-dark);
        position: relative;
        overflow-x: hidden;
    }
    
    /* Hiệu ứng nền động */
    body::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(67, 97, 238, 0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
        z-index: -1;
    }
    
    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .container {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        width: 100%;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 8px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    }
    
    h2 {
        text-align: center;
        font-size: 28px;
        margin-bottom: 25px;
        font-weight: 700;
        color: var(--primary-color);
        position: relative;
        padding-bottom: 10px;
    }
    
    h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border-radius: 3px;
    }
    
    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        margin-bottom: 15px;
        font-size: 15px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        background-color: rgba(255, 255, 255, 0.8);
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        border-color: var(--primary-color);
    }
    
    .btn-primary {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        font-size: 16px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        margin-top: 10px;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
    }
    
    label {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 14px;
        margin-bottom: 8px;
        display: block;
    }
    
    .radio-group {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }
    
    .radio-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        cursor: pointer;
    }
    
    .radio-group input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: var(--primary-color);
    }
    
    .text-danger {
        font-size: 13px;
        margin-top: -10px;
        margin-bottom: 10px;
        color: #e74c3c;
    }
    
    #back-floating-button {
        position: fixed;
        top: 25px;
        left: 25px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 12px 20px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        z-index: 9999;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    #back-floating-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
    }
    
    /* Hiệu ứng khi load form */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .container {
        animation: fadeIn 0.5s ease-out forwards;
    }
    
    /* Responsive design */
    @media (max-width: 576px) {
        .container {
            padding: 25px 20px;
            margin: 0 15px;
        }
        
        h2 {
            font-size: 24px;
        }
        
        #back-floating-button {
            top: 15px;
            left: 15px;
            padding: 10px 15px;
            font-size: 14px;
        }
    }
    
    /* Hiệu ứng khi hover vào input */
    .form-group {
        position: relative;
    }
    
    .form-group:hover .form-control {
        border-color: var(--accent-color);
    }
    
    /* Custom checkbox */
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    /* Floating labels effect */
    .floating-label {
        position: relative;
    }
    
    .floating-label label {
        position: absolute;
        left: 15px;
        top: 12px;
        transition: all 0.3s ease;
        pointer-events: none;
        background: white;
        padding: 0 5px;
    }
    
    .floating-label .form-control:focus + label,
    .floating-label .form-control:not(:placeholder-shown) + label {
        top: -10px;
        font-size: 12px;
        color: var(--primary-color);
    }
</style>
</head>
<body>
<a href="{{ route('login') }}" onclick="goBack()" id="back-floating-button">
    <i class="fas fa-arrow-left"></i> Quay lại
</a>
<div class="container">
    <h2><i class="fas fa-user-plus me-2"></i>Đăng ký thành viên</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label for="Username"><i class="fas fa-user me-2"></i>Tên tài khoản:</label>
            <input type="text" name="username" class="form-control" placeholder="Nhập tên tài khoản" required>
            @error('username')
                <div class="text-danger"><i class="fas fa-exclamation-circle me-2"></i>{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="Password"><i class="fas fa-lock me-2"></i>Mật khẩu:</label>
            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
            @error('password')
                <div class="text-danger"><i class="fas fa-exclamation-circle me-2"></i>{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="pwd2"><i class="fas fa-lock me-2"></i>Xác nhận mật khẩu:</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu" required>
            @error('password_confirmation')
                <div class="text-danger"><i class="fas fa-exclamation-circle me-2"></i>{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label><i class="fas fa-venus-mars me-2"></i>Giới tính:</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="gender" value="0" required> 
                    <i class="fas fa-male"></i> Nam
                </label>
                <label>
                    <input type="radio" name="gender" value="1" required> 
                    <i class="fas fa-female"></i> Nữ
                </label>
            </div>
        </div>

        <div class="mb-3">
            <label for="SDT"><i class="fas fa-phone me-2"></i>Số điện thoại:</label>
            <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" required>
        </div>

        <div class="mb-3">
            <label for="Email"><i class="fas fa-envelope me-2"></i>Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
        </div>

        <div class="mb-3">
            <label for="Ngaysinh"><i class="fas fa-birthday-cake me-2"></i>Ngày sinh:</label>
            <input type="date" name="birth_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="Diachi"><i class="fas fa-home me-2"></i>Nơi sinh sống:</label>
            <input type="text" name="address" class="form-control" placeholder="Nhập nơi sinh sống" required>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i> Đăng ký
        </button>
    </form>
</div>

<script>
    function goBack() {
        window.history.back();
    }
    
    // Thêm hiệu ứng khi nhấn vào input
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.01)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });
</script>
</body>
</html>