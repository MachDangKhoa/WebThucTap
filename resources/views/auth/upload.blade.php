<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Nhận Diện Tranh</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 30px;
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
            border-radius: 8px;
            background-color: #f9f9f9;
            cursor: pointer;
        }

        .form-group input[type="file"]:hover {
            border-color: #007BFF;
        }

        .form-group input[type="submit"] {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .loader {
            display: none;
            text-align: center;
            margin-top: 20px;
        }

        .loader img {
            width: 50px;
            height: 50px;
        }

        /* Section to display results */
        #result {
            margin-top: 30px;
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        #uploaded-image {
            margin-top: 20px;
            text-align: center;
        }

        #uploaded-image img {
            max-width: 100%;
            max-height: 400px;
            border-radius: 8px;
        }

        #back-button {
            margin-top: 20px;
            padding: 12px;
            font-size: 16px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        #back-button:hover {
            background-color:rgb(47, 211, 72);
        }

        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
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
                        1. Tên nghệ sĩ: ${geminiInfo.artist || 'Không có thông tin'}\n
                        2. Phong cách và đặc điểm nghệ thuật: ${geminiInfo.style || 'Không có thông tin'}\n
                        3. Thể loại: ${geminiInfo.genre || 'Không có thông tin'}\n
                        4. Năm sáng tác: ${geminiInfo.year || 'Không rõ'}\n
                        5. Mô tả: ${geminiInfo.description || 'Không có mô tả'}\n
                        6. Các đặc điểm nghệ thuật nổi bật: ${geminiInfo.artistic_features || 'Không có thông tin'}\n
                        7. Thông tin bổ sung: ${geminiInfo.additional_info || 'Không có thông tin'}
                    `;

                    // Kiểm tra nếu tất cả các trường đều là "Không có thông tin"
                    if (Object.values(geminiInfo).every(value => value === "Không có thông tin" || !value)) {
                        resultContainer.innerHTML = `<pre>${detailedDescription}</pre>`;
                    } else {
                        const result = `
                            <h3>Thông tin từ tìm kiếm Google:</h3>
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
    </script>
</body>
</html>
