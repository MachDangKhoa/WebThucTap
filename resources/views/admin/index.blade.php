<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Painting Models</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Smooth transition for all elements */
        * {
            transition: all 0.3s ease-in-out;
        }
        
        /* Table row hover effect */
        tbody tr:hover {
            background-color: #f0f9ff;
        }

        /* Input focus effect */
        input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
            outline: none;
        }

        /* Button hover scale effect */
        button:hover {
            transform: scale(1.05);
            background-color: #2563eb;
        }

        /* Alternate row color */
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        /* Table header background */
        thead {
            background-color: #e0f2fe;
        }

        /* Highlight active model */
        .bg-green-50:hover {
            background-color: #d1fae5;
        }
        #back-floating-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 18px;
            border-radius: 50px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 9999;
            transition: background-color 0.3s, transform 0.3s;
        }

        #back-floating-button:hover {
            background-color: #28a745;
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-r from-blue-100 via-purple-100 to-pink-100">
    <a href="{{ route('admin.dashboard') }}" onclick="goBack()" id="back-floating-button">
        ← Quay lại
    </a>
    <div class="relative container mx-auto p-6">
        <!-- Hiệu ứng Background Decor -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute bg-purple-300 opacity-30 rounded-full w-96 h-96 top-[-100px] left-[-100px] blur-3xl"></div>
            <div class="absolute bg-pink-300 opacity-30 rounded-full w-96 h-96 bottom-[-100px] right-[-100px] blur-3xl"></div>
        </div>

        <div class="relative z-10"> <!-- Nội dung -->
            <h2 class="text-4xl font-bold text-center text-blue-700 mb-8 drop-shadow-md">Manage Painting Models</h2>

            <!-- Form thêm model -->
            <form action="{{ route('models.store') }}" method="POST" enctype="multipart/form-data" class="mb-8 bg-white p-6 rounded-xl shadow-xl">
                @csrf
                <div class="flex flex-wrap gap-4">
                    <!-- Tên Model -->
                    <div class="flex-1 min-w-[250px]">
                        <label for="name" class="block text-sm font-medium text-gray-700">Model Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter model name" class="border p-2 w-full rounded focus:ring-2 focus:ring-blue-300" required>
                    </div>

                    <!-- Chọn File .txt chứa tên phong cách kiến trúc -->
                    <div class="flex-1 min-w-[250px]">
                        <label for="train_name" class="block text-sm font-medium text-gray-700">Chọn file chứa tên phong cách kiến trúc</label>
                        <input type="file" id="train_name" name="train_name" accept=".txt" class="border p-2 w-full rounded focus:ring-2 focus:ring-blue-300" required>
                        <input type="text" id="trainNameFilePathTextbox" class="border p-2 mt-2 w-full rounded bg-gray-100" readonly>
                    </div>

                    <!-- Chọn File Model -->
                    <div class="flex-1 min-w-[250px]">
                        <label for="model_file" class="block text-sm font-medium text-gray-700">File model</label>
                        <input type="file" id="model_file" name="model_file" class="border p-2 w-full rounded focus:ring-2 focus:ring-blue-300" required>
                        <input type="text" id="modelFilePathTextbox" class="border p-2 mt-2 w-full rounded bg-gray-100" readonly>
                    </div>

                    <!-- Nút Submit -->
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow-md">
                            ➕ Thêm
                        </button>
                    </div>
                </div>
            </form>

            <!-- Bảng danh sách -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="px-4 py-3 text-left">id</th>
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">Paintings</th>
                            <th class="px-4 py-3 text-left">Model</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Function</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($models as $i => $m)
                            <tr class="{{ $m->is_active ? 'bg-green-50' : 'hover:bg-gray-100' }}">
                                <td class="border px-4 py-2">{{ $i + 1 }}</td>
                                <td class="border px-4 py-2">{{ $m->name }}</td>
                                <td class="border px-4 py-2 text-sm">{{$m->name_train }}</td>
                                <td class="border px-4 py-2 text-sm">{{ $m->model_path }}</td>
                                <td class="border px-4 py-2">
                                    @if($m->is_active)
                                        <span class="text-green-600 font-semibold">Active</span>
                                    @else
                                        <span class="text-gray-500">—</span>
                                    @endif
                                </td>
                                <td class="border px-4 py-2 space-x-1">
                                    <form action="{{ route('models.update', $m->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" value="{{ $m->name }}" class="border px-2 py-1 text-sm rounded">
                                        <button class="text-blue-600 hover:text-blue-800">💾</button>
                                    </form>

                                    <form action="{{ route('models.destroy', $m->id) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800">🗑️</button>
                                    </form>

                                    @unless($m->is_active)
                                        <form action="{{ route('models.use', $m->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button class="text-green-600 hover:text-green-800">✅</button>
                                        </form>
                                    @endunless
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const PaintingFileInput = document.getElementById('train_name');
        const modelFileInput = document.getElementById('model_file');
        const PaintingFilePathTextbox = document.getElementById('trainNameFilePathTextbox');
        const modelFilePathTextbox = document.getElementById('modelFilePathTextbox');

        PaintingFileInput.addEventListener('change', function () {
            const file = PaintingFileInput.files[0];
            if (file) {
                PaintingFilePathTextbox.value = file.name;
            }
        });

        modelFileInput.addEventListener('change', function () {
            const file = modelFileInput.files[0];
            if (file) {
                modelFilePathTextbox.value = file.name;
            }
        });

        function goBack() {
            window.history.back();
        }
    </script>

</body>


</html>
