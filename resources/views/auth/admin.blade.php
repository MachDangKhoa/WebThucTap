<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hệ thống nhận diện tranh</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        canvas {
            animation: slideIn 0.8s ease-out forwards;
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
        .paintings-card {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }
        .api-card {
            background: linear-gradient(135deg, #f46b45 0%, #eea849 100%);
            color: white;
        }
        .models-card {
            background: linear-gradient(135deg,rgb(243, 36, 157) 0%,rgb(97, 0, 224) 100%);
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
        
        /* Chart container */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
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
        <div class="w-full md:w-64 art-bg text-white p-6 flex flex-col justify-between shadow-xl" id="sidebar">
            <div>
                <h2 class="text-3xl font-semibold mb-8 text-center flex items-center justify-center">
                    <span class="bg-white text-indigo-700 p-2 rounded-full mr-2">🎨</span> 
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-green-400 to-blue-500">
                        Admin
                    </span>
                </h2>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} pulse">
                            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('accounts.index') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link {{ request()->routeIs('accounts.index') ? 'active' : '' }} pulse">
                            <i class="fas fa-users mr-3"></i> Quản lý người dùng
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('paintings.index') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link {{ request()->routeIs('paintings.index') ? 'active' : '' }} pulse">
                            <i class="fas fa-image mr-3"></i> Quản lý tranh
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('api') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link {{ request()->routeIs('api') ? 'active' : '' }} pulse">
                            <i class="fas fa-chart-line mr-3"></i> API Usage
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.website-config.index') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link {{ request()->routeIs('admin.website-config.index') ? 'active' : '' }} pulse">
                            <i class="fas fa-cogs mr-3"></i> Cấu hình website
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('api.config.form') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link {{ request()->routeIs('api.config.form') ? 'active' : '' }} pulse">
                            <i class="fas fa-key mr-3"></i> Quản lý API Key
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.models.index') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link {{ request()->routeIs('admin.models.index') ? 'active' : '' }} pulse">
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
                        Dashboard Quản Lý
                    </span>
                </h1>
                <div class="text-sm text-gray-500 bg-white p-3 rounded-lg shadow-sm">
                    <i class="fas fa-calendar-alt mr-2 text-blue-500"></i> 
                    <span class="font-medium">{{ now()->format('d/m/Y') }}</span>
                </div>
            </div>

            <!-- Thống kê -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Người dùng -->
                <div class="p-6 rounded-xl shadow-lg card-hover transition duration-300 users-card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20 text-white mr-4">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div>
                            <p class="text-white text-opacity-80">Người dùng</p>
                            <h3 class="text-2xl font-bold">{{ count($accounts) }}</h3>
                            <p class="text-xs mt-1 text-white text-opacity-70">Đã đăng ký</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-2 border-t border-white border-opacity-20">
                        <a href="{{ route('accounts.index') }}" class="text-xs text-white hover:text-white text-opacity-80 hover:text-opacity-100 flex items-center">
                            Xem chi tiết <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Tác phẩm -->
                <div class="p-6 rounded-xl shadow-lg card-hover transition duration-300 paintings-card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20 text-white mr-4">
                            <i class="fas fa-image text-xl"></i>
                        </div>
                        <div>
                            <p class="text-white text-opacity-80">Tranh được nhận diện</p>
                            <h3 class="text-2xl font-bold">{{ count($paintingDb ?? []) + count($paintingGoogle ?? []) }}</h3>
                            <p class="text-xs mt-1 text-white text-opacity-70">Trong hệ thống</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-2 border-t border-white border-opacity-20">
                        <a href="{{ route('paintings.index') }}" class="text-xs text-white hover:text-white text-opacity-80 hover:text-opacity-100 flex items-center">
                            Xem chi tiết <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <!-- API Calls -->
                <div class="p-6 rounded-xl shadow-lg card-hover transition duration-300 api-card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20 text-white mr-4">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <div>
                            <p class="text-white text-opacity-80">API Calls</p>
                            <h3 class="text-2xl font-bold">{{ $totalCallCount }}</h3>
                            <p class="text-xs mt-1 text-white text-opacity-70">Lượt gọi API</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-2 border-t border-white border-opacity-20">
                        <a href="{{ route('api') }}" class="text-xs text-white hover:text-white text-opacity-80 hover:text-opacity-100 flex items-center">
                            Xem chi tiết <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Models -->
                <div class="p-6 rounded-xl shadow-lg card-hover transition duration-300 models-card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20 text-white mr-4">
                            <i class="fas fa-sliders-h text-xl"></i>
                        </div>
                        <div>
                            <p class="text-white text-opacity-80">Models</p>
                            <h3 class="text-2xl font-bold">{{ count($models) }}</h3>
                            <p class="text-xs mt-1 text-white text-opacity-70">Đang hoạt động</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-2 border-t border-white border-opacity-20">
                        <a href="{{ route('admin.models.index') }}" class="text-xs text-white hover:text-white text-opacity-80 hover:text-opacity-100 flex items-center">
                            Xem chi tiết <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ thống kê nhận diện tranh -->
            <div class="w-full mb-8">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center justify-center">
                    <i class="fas fa-chart-pie text-blue-500 mr-2 text-2xl"></i>
                    TỶ LỆ NGUỒN TRANH NHẬN DIỆN
                </h3>
                
                <!-- Container biểu đồ - chiếm toàn bộ chiều rộng -->
                <div class="chart-container" style="height: 300px;">
                    <canvas id="sourceChart"></canvas>
                </div>
                
                <!-- Chú thích -->
                <div class="mt-6 text-base text-gray-700 text-center">
                    <div class="flex flex-wrap justify-center gap-4">
                        <div class="flex items-center bg-blue-50 px-4 py-2 rounded-lg">
                            <span class="w-4 h-4 bg-blue-500 rounded-full mr-2"></span> 
                            <span class="font-medium">Datasets: {{ count($paintingDb ?? []) }} tranh</span>
                        </div>
                        <div class="flex items-center bg-green-50 px-4 py-2 rounded-lg">
                            <span class="w-4 h-4 bg-green-500 rounded-full mr-2"></span> 
                            <span class="font-medium">Google Search: {{ count($paintingGoogle ?? []) }} tranh</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Thống kê chi tiết -->
            <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-table text-indigo-500 mr-2"></i>
                    Thống kê chi tiết nhận diện tranh
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nguồn</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tỷ lệ</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                        <span>Dataset</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ count($paintingDb ?? []) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if((count($paintingDb ?? []) + count($paintingGoogle ?? [])) > 0)
                                        {{ round(count($paintingDb ?? []) / (count($paintingDb ?? []) + count($paintingGoogle ?? [])) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('paintings.index') }}?source=dataset" class="text-blue-500 hover:text-blue-700">Xem danh sách</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                        <span>Google Search</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ count($paintingGoogle ?? []) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if((count($paintingDb ?? []) + count($paintingGoogle ?? [])) > 0)
                                        {{ round(count($paintingGoogle ?? []) / (count($paintingDb ?? []) + count($paintingGoogle ?? [])) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('paintings.index') }}?source=google" class="text-blue-500 hover:text-blue-700">Xem danh sách</a>
                                </td>
                            </tr>
                            <tr class="bg-gray-50 font-semibold">
                                <td class="px-6 py-4 whitespace-nowrap">Tổng cộng</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ count($paintingDb ?? []) + count($paintingGoogle ?? []) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">100%</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('paintings.index') }}" class="text-blue-500 hover:text-blue-700">Xem tất cả</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                        window.location.href = "{{ route('login') }}";
                    },
                    error: function() {
                        alert('Đăng xuất thất bại. Vui lòng thử lại.');
                    }
                });
            }
        });

        // Animation for cards on scroll
        $(window).scroll(function() {
            $('.card-hover').each(function() {
                var cardTop = $(this).offset().top;
                var windowBottom = $(window).scrollTop() + $(window).height();
                if (cardTop < windowBottom) {
                    $(this).addClass('animate__animated animate__fadeInUp');
                }
            });
        });

        // Biểu đồ tròn tỷ lệ nguồn tranh
        const sourceCtx = document.getElementById('sourceChart').getContext('2d');
        const sourceChart = new Chart(sourceCtx, {
            type: 'pie',
            data: {
                labels: ['Datasets', 'Google Search'],
                datasets: [{
                    data: [{{ count($paintingDb ?? []) }}, {{ count($paintingGoogle ?? []) }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(75, 192, 192, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        
    </script>
</body>
</html> 