<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Nhận Diện Tranh</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background: linear-gradient(135deg, #f0f4f8, #d9e4f5, #fef6e4); /* Background sáng hơn */
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow-x: hidden;
        position: relative;
    }

    /* Tạo các vệt sáng ảo */
    body::before, body::after {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.6) 0%, rgba(255,255,255,0) 70%);
        z-index: 0;
        filter: blur(80px);
    }
    body::before {
        top: -100px;
        left: -100px;
    }
    body::after {
        bottom: -100px;
        right: -100px;
    }

    .navbar {
        background-color: #1f2a3f;
        padding: 15px;
        width: 100%;
        z-index: 10;
    }

    .navbar-brand, .navbar-nav .nav-link {
        color: white;
        transition: color 0.3s ease;
    }

    .navbar-brand:hover, .navbar-nav .nav-link:hover {
        color: #1abc9c;
    }

    .container {
        position: relative;
        z-index: 10;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        padding: 40px;
        max-width: 650px;
        width: 90%;
        margin: 50px auto;
        transition: all 0.3s ease;
    }

    .container:hover {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
        transform: translateY(-5px);
    }

    h2 {
        text-align: center;
        font-size: 30px;
        margin-bottom: 25px;
        color: #34495e;
        font-weight: 700;
        text-shadow: 1px 1px 2px #e0e0e0;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        font-size: 16px;
        margin-bottom: 8px;
        color: #555;
    }

    .form-group input[type="file"] {
        width: 100%;
        padding: 15px;
        font-size: 16px;
        border: 2px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
        cursor: pointer;
        transition: border-color 0.3s ease;
    }

    .form-group input[type="file"]:hover {
        border-color: #007BFF;
    }

    .form-group input[type="submit"] {
        width: 100%;
        padding: 15px;
        font-size: 18px;
        border: none;
        background: linear-gradient(135deg, #007BFF, #00c6ff);
        color: white;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s ease;
    }

    .form-group input[type="submit"]:hover {
        background: linear-gradient(135deg, #00b227, #00f260);
        transform: translateY(-2px);
    }

    .loader {
        display: none;
        text-align: center;
        margin-top: 20px;
    }

    .loader img {
        width: 60px;
        height: 60px;
    }

    #result {
        margin-top: 30px;
        background: #f8f8f8;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #ddd;
    }

    #uploaded-image {
        margin-top: 20px;
        text-align: center;
    }

    #uploaded-image img {
        max-width: 100%;
        max-height: 400px;
        border-radius: 10px;
    }

    #back-button {
        margin-top: 20px;
        padding: 12px;
        font-size: 16px;
        background-color: #e74c3c;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    #back-button:hover {
        background-color: #2ecc71;
        transform: translateY(-2px);
    }

    pre {
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .footer {
        margin-top: 40px;
        font-size: 14px;
        color: #999;
        text-align: center;
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

    @media (max-width: 768px) {
        .container {
            padding: 25px;
        }
        h2 {
            font-size: 24px;
        }
    }
    </style>

</head>
<body>
    <a href="{{ route('dashboard') }}" onclick="goBack()" id="back-floating-button">
        ← Quay lại
    </a>
    <div class="container">
        <h2>Hệ thống nhận diện tranh</h2>
        <form method="POST" enctype="multipart/form-data" action="{{ url('/predict') }}" id="predict-form">
            @csrf
            <div class="form-group">
                <label for="image">Chọn ảnh tranh</label>
                <input type="file" name="image" accept="image/*" required id="image-input">
            </div>
            <div class="form-group">
                <input type="submit" value="Nhận diện tranh">
            </div>
        </form>

        <div class="loader" id="loader">
            <img src="https://i.imgur.com/llF5iyg.gif" alt="Loading">
        </div>

        <!-- Uploaded Image Display -->
        <div id="uploaded-image"></div>

        <!-- Result Section -->
        <div id="result"></div>

        <!-- Back Button -->
        <button id="back-button" style="display: none;">Chọn tranh khác</button>

        <!-- Footer -->
        <div class="footer">
            <p>© 2025 Hệ Thống Nhận Diện Tranh</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('predict-form');
        const loader = document.getElementById('loader');
        const resultContainer = document.getElementById('result');
        const uploadedImageContainer = document.getElementById('uploaded-image');
        const imageInput = document.getElementById('image-input');
        const backButton = document.getElementById('back-button');

        // Hiển thị ảnh trước khi gửi yêu cầu
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    uploadedImageContainer.innerHTML = `<img src="${e.target.result}" alt="Uploaded Image">`;
                };
                reader.readAsDataURL(file);
            }
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngừng submit mặc định
            loader.style.display = 'block'; // Hiển thị loader

            const formData = new FormData(form);

            fetch('{{ url("/predict") }}', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                loader.style.display = 'none'; // Ẩn loader sau khi nhận dữ liệu

                // Kiểm tra lỗi nếu có
                if (data.error) {
                    resultContainer.innerHTML = `<p style="color: red;">${data.error}</p>`;
                    return;
                }
                // Nếu dữ liệu từ Dataset Cosine có thông tin
                if (data.source === "Dataset Cosine") {
                    const result = ` 
                        <h3>Tên Tranh: ${data.info.painting_title}</h3>
                        <p><strong>Tác giả:</strong> ${data.info.artist}</p>
                        <p><strong>Nhiếp ảnh:</strong> ${data.info.photographer}</p>
                        <p><strong>Phong cách:</strong> ${data.info.style}</p>
                        <p><strong>Độ tương đồng:</strong> ${data.info.similarity}</p>
                        <p><strong>Mô tả:</strong> ${data.info.description || "Không có mô tả."}</p>
                    `;
                    resultContainer.innerHTML = result;
                }
                // Nếu dữ liệu từ Google Image và Gemini có thông tin
                else if (data.source === "Google Image") {
                    const geminiInfo = data.gemini_info;

                    // Tạo mô tả chi tiết nếu không có thông tin hợp lệ
                    const detailedDescription = `
                        Thông tin về bức tranh:\n
                        1. Tên bức tranh: ${geminiInfo.title || 'Không có thông tin'}\n
                        2. Tên nghệ sĩ: ${geminiInfo.artist || 'Không có thông tin'}\n
                        3. Phong cách và đặc điểm nghệ thuật: ${geminiInfo.style || 'Không có thông tin'}\n
                        4. Thể loại: ${geminiInfo.genre || 'Không có thông tin'}\n
                        5. Năm sáng tác: ${geminiInfo.year || 'Không rõ'}\n
                        6. Mô tả: ${geminiInfo.description || 'Không có mô tả'}\n
                        7. Các đặc điểm nghệ thuật nổi bật: ${geminiInfo.artistic_features || 'Không có thông tin'}\n
                        8. Thông tin bổ sung: ${geminiInfo.additional_info || 'Không có thông tin'}
                    `;

                    // Kiểm tra nếu tất cả các trường đều là "Không có thông tin"
                    if (Object.values(geminiInfo).every(value => value === "Không có thông tin" || !value)) {
                        resultContainer.innerHTML = `<pre>${detailedDescription}</pre>`;
                    } else {
                        const result = `
                            <h3>Thông tin từ tìm kiếm Google:</h3>
                            <p><strong>Tên bức tranh:</strong> ${geminiInfo.title || 'Không có thông tin'}</p>
                            <p><strong>Tên nghệ sĩ:</strong> ${geminiInfo.artist || 'Không có thông tin'}</p>
                            <p><strong>Phong cách:</strong> ${geminiInfo.style || 'Không có thông tin'}</p>
                            <p><strong>Thể loại:</strong> ${geminiInfo.genre || 'Không có thông tin'}</p>
                            <p><strong>Năm sáng tác:</strong> ${geminiInfo.year || 'Không rõ'}</p>
                            <p><strong>Mô tả:</strong> ${geminiInfo.description || 'Không có mô tả.'}</p>
                            <p><strong>Các đặc điểm nghệ thuật nổi bật:</strong> ${geminiInfo.artistic_features || 'Không có thông tin'}</p>
                            <p><strong>Thông tin bổ sung:</strong> ${geminiInfo.additional_info || 'Không có thông tin'}</p>
                        `;
                        resultContainer.innerHTML = result;
                    }
                }

                backButton.style.display = 'block'; // Hiển thị nút quay lại
            })
            .catch(error => {
                loader.style.display = 'none';
                resultContainer.innerHTML = `<p style="color: red;">Đã có lỗi xảy ra. Vui lòng thử lại sau.</p>`;
                console.error('Error:', error);
            });
        });

        backButton.addEventListener('click', function() {
            resultContainer.innerHTML = '';
            uploadedImageContainer.innerHTML = '';
            backButton.style.display = 'none';
            imageInput.value = '';
        });

        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
