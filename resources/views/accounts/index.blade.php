<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Quản lý người dùng</title>
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
        /* Animation for charts */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Quick action hover effects */
        .quick-action:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        /* Table row hover */
        tbody tr:hover {
            background-color: #f9fafb;
        }
        /* Gradient backgrounds for stats cards */
        .users-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        /* Pulse animation for active elements */
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
                        <a href="{{ route('accounts.index') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link active pulse">
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
        <div class="flex-1 p-6 md:p-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-green-500">
                        Quản lý người dùng
                    </span>
                </h1>
                <div class="text-sm text-gray-500 bg-white p-3 rounded-lg shadow-sm">
                    <i class="fas fa-calendar-alt mr-2 text-blue-500"></i> 
                    <span class="font-medium">{{ now()->format('d/m/Y') }}</span>
                </div>
            </div>

            <!-- Hiển thị thông báo -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @elseif(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Danh sách tài khoản -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">
                            <i class="fas fa-users mr-2 text-blue-500"></i>
                            Danh sách tài khoản
                        </h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giới tính</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số điện thoại</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($accounts as $account)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-r from-purple-400 to-blue-500 flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($account->username, 0, 1)) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $account->username }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $account->gender == 0 ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                            {{ $account->gender == 0 ? 'Nam' : 'Nữ' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $account->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $account->phone }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('accounts.edit', $account->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <i class="fas fa-edit mr-1"></i> Sửa
                                            </a>
                                            <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">
                                                    <i class="fas fa-trash-alt mr-1"></i> Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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