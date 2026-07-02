<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cấu hình Website - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; display: none; }
        }
        .fade-out {
            animation: fadeOut 1.5s forwards;
        }
        .art-bg {
            background: linear-gradient(135deg, rgba(30, 39, 46, 1) 0%, rgba(58, 85, 103, 1) 100%);
        }
        .sidebar-link:hover {
            background-color: rgba(26, 188, 156, 0.2);
            transform: translateX(5px);
            transition: all 0.3s ease;
        }
        .sidebar-link.active {
            background-color: #1abc9c;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .quick-action:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        tbody tr:hover {
            background-color: #f9fafb;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .pulse:hover {
            animation: pulse 1.5s infinite;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans leading-normal tracking-normal">

    @if (session('status'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4 flex items-center space-x-3 shadow-lg" id="status-message">
            <i class="fas fa-check-circle text-xl animate-bounce"></i>
            <span>{{ session('status') }}</span>
        </div>
        <script>
            setTimeout(() => document.getElementById('status-message').classList.add('fade-out'), 1500);
        </script>
    @endif

    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        <div class="w-full md:w-64 art-bg text-white p-6 flex flex-col justify-between shadow-xl">
            <div>
                <h2 class="text-3xl font-semibold mb-8 text-center flex items-center justify-center">
                    <span class="bg-white text-indigo-700 p-2 rounded-full mr-2">🎨</span> 
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-green-400 to-blue-500">
                        Admin
                    </span>
                </h2>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link pulse">
                            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('accounts.index') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link pulse">
                            <i class="fas fa-users mr-3"></i> Quản lý người dùng
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('paintings.index') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link pulse">
                            <i class="fas fa-image mr-3"></i> Quản lý tranh
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('api') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link pulse">
                            <i class="fas fa-chart-line mr-3"></i> API Usage
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.website-config.index') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link active pulse">
                            <i class="fas fa-cogs mr-3"></i> Cấu hình website
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('api.config.form') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link pulse">
                            <i class="fas fa-key mr-3"></i> Quản lý API Key
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.models.index') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link pulse">
                            <i class="fas fa-sliders-h mr-3"></i> Quản lý Models
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mt-8">
                @if(Auth::check())
                <div class="text-center mb-4 text-gray-300 flex items-center justify-center">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-400 to-blue-500 flex items-center justify-center mr-3">
                        <span class="text-white font-bold">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="text-sm">Xin chào,</p>
                        <p class="font-medium">{{ Auth::user()->username }}</p>
                    </div>
                </div>
                @endif
                
                <form id="logout" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full py-3 px-4 text-white bg-red-500 hover:bg-red-600 rounded-lg text-center font-semibold transition duration-300 shadow-md hover:shadow-lg">
                        <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 md:p-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-green-500">
                        Cấu hình Website
                    </span>
                </h1>
                <div class="text-sm text-gray-500 bg-white p-3 rounded-lg shadow-sm">
                    <i class="fas fa-calendar-alt mr-2 text-blue-500"></i> 
                    <span class="font-medium">{{ now()->format('d/m/Y') }}</span>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <form action="{{ route('admin.website-config.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Thông tin cơ bản -->
                        <div class="md:col-span-2">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                Thông tin cơ bản
                            </h3>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tên Website</label>
                            <input type="text" name="website_name" value="{{ old('website_name', $config->website_name) }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                            <textarea name="description" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('description', $config->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Từ khóa</label>
                            <input type="text" name="keywords" value="{{ old('keywords', $config->keywords) }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <p class="text-xs text-gray-500 mt-1">Các từ khóa phân cách bằng dấu phẩy</p>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sitemap URL</label>
                            <input type="url" name="sitemap" value="{{ old('sitemap', $config->sitemap) }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Hình ảnh -->
                        <div class="md:col-span-2 mt-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-image text-blue-500 mr-2"></i>
                                Hình ảnh
                            </h3>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                            <input type="file" name="logo" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @if($config->logo)
                                <div class="mt-2 flex items-center">
                                    <img src="{{ asset('storage/' . $config->logo) }}" alt="Logo" class="h-16 w-auto mr-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="remove_logo" class="mr-2">
                                        <span class="text-sm text-gray-600">Xóa logo hiện tại</span>
                                    </label>
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Favicon</label>
                            <input type="file" name="favicon" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @if($config->favicon)
                                <div class="mt-2 flex items-center">
                                    <img src="{{ asset('storage/' . $config->favicon) }}" alt="Favicon" class="h-10 w-auto mr-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="remove_favicon" class="mr-2">
                                        <span class="text-sm text-gray-600">Xóa favicon hiện tại</span>
                                    </label>
                                </div>
                            @endif
                        </div>

                        <!-- Cấu hình hệ thống -->
                        <div class="md:col-span-2 mt-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-cog text-blue-500 mr-2"></i>
                                Cấu hình hệ thống
                            </h3>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái Website</label>
                            <select name="website_status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="active" {{ old('website_status', $config->website_status) == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="maintenance" {{ old('website_status', $config->website_status) == 'maintenance' ? 'selected' : '' }}>Bảo trì</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Loại website</label>
                            <select name="website_type" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="store" {{ old('website_type', $config->website_type) == 'store' ? 'selected' : '' }}>Cửa hàng</option>
                                <option value="simple" {{ old('website_type', $config->website_type) == 'simple' ? 'selected' : '' }}>Đơn giản</option>
                                <option value="product_catalog" {{ old('website_type', $config->website_type) == 'product_catalog' ? 'selected' : '' }}>Danh mục sản phẩm</option>
                            </select>
                        </div>

                        <!-- Thông tin liên hệ -->
                        <div class="md:col-span-2 mt-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-address-book text-blue-500 mr-2"></i>
                                Thông tin liên hệ
                            </h3>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email liên hệ</label>
                            <input type="email" name="contact_email" value="{{ old('contact_email', $config->contact_email) }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                            <input type="text" name="contact_phone" value="{{ old('contact_phone', $config->contact_phone) }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <div class="form-group md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
                            <input type="text" name="address" value="{{ old('address', $config->address) }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <div class="form-group md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Thông tin kinh doanh</label>
                            <textarea name="business_info" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 h-32">{{ old('business_info', $config->business_info) }}</textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-4">
                        <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-300">
                            <i class="fas fa-undo mr-2"></i> Đặt lại
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-300">
                            <i class="fas fa-save mr-2"></i> Lưu cấu hình
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="art-bg text-white py-4 px-6">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-sm">© 2025 Hệ Thống Nhận Diện Tranh - Admin</p>
                    <p class="text-xs text-gray-300 mt-1">Phiên bản 1.0 - Tháng 5, 2025</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/api/docs" target="_blank" class="text-sm hover:text-green-300 transition flex items-center">
                        <i class="fas fa-book mr-1"></i> API Docs
                    </a>
                    <a href="#" class="text-sm hover:text-green-300 transition flex items-center">
                        <i class="fas fa-question-circle mr-1"></i> Trợ giúp
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Preview image khi chọn file
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const preview = document.createElement('img');
                        preview.src = event.target.result;
                        preview.className = 'h-16 w-auto mt-2';
                        
                        const container = input.nextElementSibling;
                        if (container) {
                            const existingPreview = container.querySelector('img');
                            if (existingPreview) {
                                existingPreview.replaceWith(preview);
                            } else {
                                container.prepend(preview);
                            }
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });
        });

        // Xử lý logout
        $('#logout').on('submit', function(event) {
            event.preventDefault();
            if(confirm('Bạn có chắc chắn muốn đăng xuất?')) {
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function() {
                        window.location.href = "{{ route('home') }}";
                    },
                    error: function() {
                        alert('Đăng xuất thất bại. Vui lòng thử lại.');
                    }
                });
            }
        });
    </script>
</body>
</html>