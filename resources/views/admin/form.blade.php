<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý API Key - Admin</title>
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
        .w-full.md\:w-64 {
            flex: 0 0 16rem; /* Cố định width và không co giãn */
            min-width: 16rem;
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
        .api-key-mask {
            font-family: monospace;
            letter-spacing: 2px;
        }
        /* Thêm style mới */
        .toggle-password {
            transition: all 0.3s ease;
        }
        .toggle-password:hover {
            color: #3b82f6 !important;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans leading-normal tracking-normal">

    <div class="flex flex-col md:flex-row min-h-screen">
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
                        <a href="{{ route('admin.website-config.index') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link pulse">
                            <i class="fas fa-cogs mr-3"></i> Cấu hình website
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('api.config.form') }}" class="flex items-center py-3 px-4 rounded-lg sidebar-link active pulse">
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
                        Cấu hình API
                    </span>
                </h1>
                <div class="text-sm text-gray-500 bg-white p-3 rounded-lg shadow-sm">
                    <i class="fas fa-calendar-alt mr-2 text-blue-500"></i> 
                    <span class="font-medium">{{ now()->format('d/m/Y') }}</span>
                </div>
            </div>

            <!-- Status Messages -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                    <div>
                        <p class="font-medium">Thành công!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                        <div>
                            <p class="font-medium">Có lỗi xảy ra!</p>
                            <ul class="list-disc list-inside mt-1 text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- API Configuration Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover transition duration-300 mb-8">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <i class="fas fa-key text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">Cấu hình API hiện tại</h3>
                            <p class="text-sm text-gray-500">Thay đổi thông tin kết nối API tại đây</p>
                        </div>
                    </div>

                    <form action="{{ route('api.config.storeOrUpdate') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- LLM Selection -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Dịch vụ AI</label>
                                <div class="relative">
                                    <select name="llm_name" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                                        <option value="Gemini" {{ old('llm_name', $config->llm_name ?? '') == 'Gemini' ? 'selected' : '' }}>Google Gemini</option>
                                        <option value="ChatGPT" {{ old('llm_name', $config->llm_name ?? '') == 'ChatGPT' ? 'selected' : '' }}>OpenAI ChatGPT</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <i class="fas fa-chevron-down text-sm"></i>
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Chọn dịch vụ AI bạn muốn sử dụng</p>
                            </div>

                            <!-- API Key -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">API Key</label>
                                <div class="relative">
                                    <input type="password" name="api_key" value="{{ old('api_key', $config->api_key ?? '') }}" 
                                           class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 api-key-mask" 
                                           placeholder="sk-... hoặc AIzaSy..." required>
                                    <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 toggle-password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @if(isset($config) && $config->api_key)
                                <p class="mt-1 text-xs text-gray-500">API Key hiện tại: {{ substr($config->api_key, 0, 4) }}****{{ substr($config->api_key, -4) }}</p>
                                @endif
                            </div>

                            <!-- Model Name -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tên Model</label>
                                <input type="text" name="model_name" value="{{ old('model_name', $config->model_name ?? '') }}" 
                                       class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                       placeholder="Ví dụ: gemini-pro, gpt-4" required>
                                <p class="mt-1 text-xs text-gray-500">Nhập tên model chính xác từ nhà cung cấp</p>
                            </div>

                            <!-- Test Connection Button -->
                            <div class="form-group flex items-end">
                                <button type="button" id="test-connection" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                                    <i class="fas fa-plug mr-2"></i> Kiểm tra kết nối
                                </button>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end space-x-4 border-t pt-6">
                            <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg transition duration-300 flex items-center">
                                <i class="fas fa-arrow-left mr-2"></i> Quay lại
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-300 flex items-center">
                                <i class="fas fa-save mr-2"></i> Lưu cấu hình
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- API Documentation Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover transition duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="bg-purple-100 p-3 rounded-full mr-4">
                            <i class="fas fa-book text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">Hướng dẫn API</h3>
                            <p class="text-sm text-gray-500">Tài liệu và hướng dẫn sử dụng API</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Gemini Documentation -->
                        <div class="border rounded-lg p-4 hover:border-blue-300 transition duration-300">
                            <div class="flex items-center mb-3">
                                <img src="https://www.gstatic.com/lamda/images/gemini_sparkle_v002_d4735304ff6292a690345.svg" alt="Gemini" class="h-6 mr-2">
                                <h4 class="font-medium text-gray-800">Google Gemini</h4>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Hướng dẫn sử dụng Google Gemini API</p>
                            <ul class="text-xs space-y-2 text-gray-500">
                                <li><i class="fas fa-check-circle text-green-500 mr-2"></i> API Key từ Google AI Studio</li>
                                <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Model name: gemini-pro</li>
                                <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Miễn phí với giới hạn</li>
                            </ul>
                            <a href="https://ai.google.dev/" target="_blank" class="mt-3 inline-block text-sm text-blue-600 hover:underline">
                                <i class="fas fa-external-link-alt mr-1"></i> Tài liệu chính thức
                            </a>
                        </div>

                        <!-- ChatGPT Documentation -->
                        <div class="border rounded-lg p-4 hover:border-blue-300 transition duration-300">
                            <div class="flex items-center mb-3">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/ChatGPT_logo.svg" alt="ChatGPT" class="h-6 mr-2">
                                <h4 class="font-medium text-gray-800">OpenAI ChatGPT</h4>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Hướng dẫn sử dụng OpenAI API</p>
                            <ul class="text-xs space-y-2 text-gray-500">
                                <li><i class="fas fa-check-circle text-green-500 mr-2"></i> API Key từ OpenAI Platform</li>
                                <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Model name: gpt-3.5-turbo hoặc gpt-4</li>
                                <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Tính phí theo token</li>
                            </ul>
                            <a href="https://platform.openai.com/docs/" target="_blank" class="mt-3 inline-block text-sm text-blue-600 hover:underline">
                                <i class="fas fa-external-link-alt mr-1"></i> Tài liệu chính thức
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        $(document).on('click', '.toggle-password', function() {
            const input = $(this).siblings('input');
            const icon = $(this).find('i');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Test connection button
        $('#test-connection').click(function() {
            const button = $(this);
            const originalText = button.html();
            
            button.html('<i class="fas fa-spinner fa-spin mr-2"></i> Đang kiểm tra...');
            button.prop('disabled', true);
            
            // Simulate API test (replace with actual API test)
            setTimeout(() => {
                button.html('<i class="fas fa-check-circle mr-2"></i> Kết nối thành công');
                button.removeClass('bg-gray-200 hover:bg-gray-300 text-gray-800')
                     .addClass('bg-green-100 text-green-800');
                
                // Reset after 3 seconds
                setTimeout(() => {
                    button.html(originalText);
                    button.removeClass('bg-green-100 text-green-800')
                         .addClass('bg-gray-200 hover:bg-gray-300 text-gray-800');
                    button.prop('disabled', false);
                }, 3000);
            }, 1500);
        });
    </script>
</body></html>