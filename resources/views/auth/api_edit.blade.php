<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa API Usage - Admin</title>
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
        .sidebar-container {
            width: 16rem;
            min-width: 16rem;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        .main-content {
            flex-grow: 1;
            min-width: 0;
        }
        @media (max-width: 768px) {
            .flex {
                flex-direction: column;
            }
            .sidebar-container {
                width: 100%;
                min-width: 100%;
                height: auto;
                position: relative;
            }
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
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .pulse:hover {
            animation: pulse 1.5s infinite;
        }
        .form-input {
            transition: all 0.3s ease;
            border: 1px solid #d1d5db;
        }
        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .api-endpoint {
            font-family: monospace;
            background-color: #f3f4f6;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
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

    <div class="flex">
        <!-- Sidebar -->
        <div class="sidebar-container art-bg text-white p-6 flex flex-col justify-between shadow-xl">
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
                        <a href="{{ route('api') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link active pulse">
                            <i class="fas fa-chart-line mr-3"></i> API Usage
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.website-config.index') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link pulse">
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
        <div class="main-content p-6 md:p-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-green-500">
                        Chỉnh sửa API Usage
                    </span>
                </h1>
                <div class="text-sm text-gray-500 bg-white p-3 rounded-lg shadow-sm">
                    <i class="fas fa-calendar-alt mr-2 text-blue-500"></i> 
                    <span class="font-medium">{{ now()->format('d/m/Y') }}</span>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                    <div>
                        <p class="font-medium">Thành công!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                    <div>
                        <p class="font-medium">Lỗi!</p>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Form chỉnh sửa -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover transition duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="bg-indigo-100 p-3 rounded-full mr-4">
                            <i class="fas fa-code text-indigo-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">Thông tin API Usage</h3>
                            <p class="text-sm text-gray-500">Cập nhật thông tin sử dụng API</p>
                        </div>
                    </div>

                    <form action="{{ route('api.update_api', $apiUsage->id) }}" method="POST" id="updateForm">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Endpoint -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">API Endpoint</label>
                                <div class="relative">
                                    <input type="text" name="endpoint" class="w-full px-4 py-3 form-input rounded-lg api-endpoint" 
                                           value="{{ old('endpoint', $apiUsage->endpoint) }}" required>
                                </div>
                            </div>

                            <!-- Call Count -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Số lần gọi</label>
                                <input type="number" name="call_count" class="w-full px-4 py-3 form-input rounded-lg" 
                                       value="{{ old('call_count', $apiUsage->call_count) }}" required>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end space-x-4 border-t pt-6">
                            <a href="{{ route('api') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg transition duration-300 flex items-center">
                                <i class="fas fa-arrow-left mr-2"></i> Quay lại
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-300 flex items-center">
                                <i class="fas fa-save mr-2"></i> Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Xử lý xác nhận trước khi cập nhật
        $('#updateForm').on('submit', function(e) {
            if(!confirm('Bạn có chắc chắn muốn cập nhật thông tin API Usage này?')) {
                e.preventDefault();
            }
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