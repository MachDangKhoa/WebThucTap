<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cấu hình Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            padding: 30px;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-control {
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert-success {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        .alert {
            margin-bottom: 20px;
        }
        .form-control:focus {
            border-color: #0056b3;
        }
        .custom-img {
            max-width: 100px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="text-center">Cấu hình Website</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.website-config.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="website_name">Tên Website</label>
                <input type="text" class="form-control" name="website_name" value="{{ old('website_name', $config->website_name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea class="form-control" name="description" required>{{ old('description', $config->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="keywords">Từ khóa</label>
                <input type="text" class="form-control" name="keywords" value="{{ old('keywords', $config->keywords) }}" required>
            </div>

            <!-- <div class="form-group">
                <label for="logo">Logo</label>
                <input type="file" class="form-control" name="logo">
                @if($config->logo)
                    <img src="{{ asset('storage/' . $config->logo) }}" alt="Logo" class="custom-img">
                @endif
            </div> -->

            <div class="form-group">
                <label for="favicon">Favicon</label>
                <input type="file" class="form-control" name="favicon">
                @if($config->favicon)
                    <img src="{{ asset('storage/' . $config->favicon) }}" alt="Favicon" class="custom-img">
                @endif
            </div>

            <div class="form-group">
                <label for="sitemap">Sitemap URL</label>
                <input type="url" class="form-control" name="sitemap" value="{{ old('sitemap', $config->sitemap) }}">
            </div>

            <div class="form-group">
                <label for="website_status">Trạng thái Website</label>
                <select name="website_status" class="form-control" required>
                    <option value="active" {{ old('website_status', $config->website_status) == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="maintenance" {{ old('website_status', $config->website_status) == 'maintenance' ? 'selected' : '' }}>Bảo trì</option>
                </select>
            </div>

            <div class="form-group">
                <label for="website_type">Loại website</label>
                <select name="website_type" class="form-control" required>
                    <option value="store" {{ old('website_type', $config->website_type) == 'store' ? 'selected' : '' }}>Cửa hàng</option>
                    <option value="simple" {{ old('website_type', $config->website_type) == 'simple' ? 'selected' : '' }}>Đơn giản</option>
                    <option value="product_catalog" {{ old('website_type', $config->website_type) == 'product_catalog' ? 'selected' : '' }}>Danh mục sản phẩm</option>
                </select>
            </div>

            <div class="form-group">
                <label for="contact_email">Email liên hệ</label>
                <input type="email" class="form-control" name="contact_email" value="{{ old('contact_email', $config->contact_email) }}" required>
            </div>

            <div class="form-group">
                <label for="contact_phone">Số điện thoại</label>
                <input type="text" class="form-control" name="contact_phone" value="{{ old('contact_phone', $config->contact_phone) }}" required>
            </div>

            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" class="form-control" name="address" value="{{ old('address', $config->address) }}" required>
            </div>

            <div class="form-group">
                <label for="business_info">Thông tin kinh doanh</label>
                <textarea class="form-control" name="business_info">{{ old('business_info', $config->business_info) }}</textarea>
            </div>
            <div style="text-align: center;">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
