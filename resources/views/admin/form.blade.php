<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cấu hình API LLM</title>
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #f06, #48c6ef);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1 {
            text-align: center;
            color: #000;
            font-family: 'Dancing Script', cursive;
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 30px;
            animation: fadeIn 1.5s ease-in-out;
        }

        .container {
            max-width: 600px;
            background: #fff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            animation: zoomIn 0.8s ease-in-out;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            color: #333;
            font-weight: bold;
            transition: all 0.3s;
        }

        input,
        select {
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            color: #333;
            background-color: #f9f9f9;
            margin-top: 8px;
            transition: all 0.3s ease;
        }

        input:focus,
        select:focus {
            border-color: #007bff;
            background-color: #fff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        button:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        button:active {
            transform: scale(1.02);
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        
        .button-group {
            display: flex;
            flex-direction: column;
            gap: 20px;  /* Tạo khoảng cách giữa các nút */
        }

        .back-button {
            width: 150px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        .back-button:hover {
            background-color:rgb(12, 223, 79);
            transform: scale(1.05);
        }

        .back-button:active {
            transform: scale(1.02);
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes zoomIn {
            0% {
                transform: scale(0.8);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Cấu hình LLM</h1>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Alert (Optional) -->
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('api.config.storeOrUpdate') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="llm_name">Chọn LLM:</label>
            <select name="llm_name" id="llm_name" class="form-control">
                <option value="Gemini" {{ old('llm_name', $config->llm_name ?? '') == 'Gemini' ? 'selected' : '' }}>Gemini</option>
                <option value="ChatGPT" {{ old('llm_name', $config->llm_name ?? '') == 'ChatGPT' ? 'selected' : '' }}>ChatGPT</option>
            </select>
        </div>

        <div class="form-group">
            <label for="api_key">API Key:</label>
            <input type="text" name="api_key" id="api_key" value="{{ old('api_key', $config->api_key ?? '') }}" class="form-control" placeholder="Nhập API Key">
        </div>

        <div class="form-group">
            <label for="model_name">Model Name:</label>
            <input type="text" name="model_name" id="model_name" value="{{ old('model_name', $config->model_name ?? '') }}" class="form-control" placeholder="Nhập Model Name">
        </div>

        <div class="button-group">
            <button type="submit" class="btn btn-primary">Lưu Cấu Hình</button>
            <a href="{{ route('admin.dashboard') }}" class="back-button">Quay lại</a>
        </div>
    </form>

    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
