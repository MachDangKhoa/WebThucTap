<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Nhận Diện Tranh</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">

    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background: linear-gradient(135deg, #f0f4f8, #d9e4f5, #fef6e4);
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow-x: hidden;
        position: relative;
    }

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

    .form-group input[type="submit"]:disabled {
        background: linear-gradient(135deg, #a0aec0, #c7d2fe);
        cursor: not-allowed;
        transform: none;
    }

    .loader {
        display: none;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        margin-top: 20px;
    }

    .loader img {
        width: 50px;
        height: 50px;
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
        margin-left: auto;
        margin-right: auto;
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

    .debate-toggle {
        margin-top: 10px;
        padding: 8px 15px;
        font-size: 14px;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .debate-toggle:hover {
        background-color: #2980b9;
    }

    #debate-section {
        display: none;
        margin-top: 20px;
        padding: 15px;
        background-color: #ecf0f1;
        border-radius: 5px;
        color: #2c3e50;
        line-height: 1.6;
    }

    #debate-section h4 {
        color: #e74c3c;
        margin-bottom: 10px;
    }

    #debate-section p {
        margin-bottom: 15px;
    }

    #debate-section ul {
        margin-left: 20px;
        margin-bottom: 15px;
    }

    #debate-section li {
        margin-bottom: 8px;
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
<body class="min-h-screen bg-gradient-to-r from-blue-100 via-purple-100 to-pink-100">
    <a href="{{ route('dashboard') }}" onclick="goBack()" id="back-floating-button">
        ← Quay lại
    </a>
    <!-- Hiệu ứng Background Decor -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute bg-purple-300 opacity-30 rounded-full w-96 h-96 top-[-100px] left-[-100px] blur-3xl"></div>
        <div class="absolute bg-pink-300 opacity-30 rounded-full w-96 h-96 bottom-[-100px] right-[-100px] blur-3xl"></div>
    </div>
    <div class="container">
        <h2>Hệ thống nhận diện tranh</h2>
        <form method="POST" enctype="multipart/form-data" action="{{ url('/predict') }}" id="predict-form">
            @csrf
            <div class="form-group">
                <label for="image">Chọn ảnh tranh</label>
                <input type="file" name="image" accept="image/*" required id="image-input">
            </div>
            <div class="form-group">
                <input type="submit" value="Nhận diện tranh" id="submit-button">
            </div>
        </form>

        <div class="loader" id="loader">
            <img src="https://i.imgur.com/llF5iyg.gif" alt="Loading" style="display: block; margin: 0 auto;">
        </div>

        <!-- Uploaded Image Display -->
        <div id="uploaded-image"></div>

        <!-- Result Section -->
        <div id="result"></div>

        <!-- Debate Section -->
        <button class="debate-toggle" id="toggle-debate">Xem phần tranh luận</button>
        <div id="debate-section"></div>

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
        const submitButton = document.getElementById('submit-button');
        const debateToggle = document.getElementById('toggle-debate');
        const debateSection = document.getElementById('debate-section');

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

        const getValue = (value, defaultText = 'Không có thông tin') => value || defaultText;

        const convertMarkdownToHtml = (text) => {
            if (!text) return defaultText;
            // Thay thế các tiêu đề Markdown (###, ####) và danh sách
            let html = text
                .replace(/^###\s+(.+)$/gm, '<h3>$1</h3>') // ### -> h3
                .replace(/^####\s+(.+)$/gm, '<h4>$1</h4>') // #### -> h4
                .replace(/^\*\s+(.+)$/gm, '<li>$1</li>') // Danh sách * -> li
                .replace(/\n/g, '<br>'); // Xuống dòng -> <br>
            // Bọc danh sách trong <ul> nếu có
            html = html.replace(/(<li>.+<\/li>)/g, '<ul>$1</ul>');
            return html;
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngừng submit mặc định
            if (submitButton.disabled) return; // Ngăn gửi lại nếu nút đã vô hiệu hóa

            loader.style.display = 'block'; // Hiển thị loader
            submitButton.disabled = true; // Vô hiệu hóa nút submit

            const formData = new FormData(form);

            fetch('{{ url("/predict") }}', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                loader.style.display = 'none'; // Ẩn loader sau khi nhận dữ liệu
                submitButton.disabled = false; // Kích hoạt lại nút submit

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
                    const agentDebate = data["Agent Debate"];
                    const finalResult = agentDebate.final_result;
                    const information = agentDebate.information;
                    console.log("Data received:", data);
                    console.log("Final Result:", finalResult);

                    // Tạo mô tả chi tiết nếu không có thông tin hợp lệ
                    const detailedDescription = `
                        Thông tin về bức tranh:\n
                        1. Tên bức tranh: ${finalResult?.title || 'Không có thông tin'}\n
                        2. Tên nghệ sĩ: ${finalResult?.artist || 'Không có thông tin'}\n
                        3. Phong cách và đặc điểm nghệ thuật: ${finalResult?.style || 'Không có thông tin'}\n
                        4. Thể loại: ${finalResult?.genre || 'Không có thông tin'}\n
                        5. Năm sáng tác: ${finalResult?.year || 'Không rõ'}\n
                        6. Mô tả: ${finalResult?.description || 'Không có mô tả'}\n
                        7. Các đặc điểm nghệ thuật nổi bật: ${finalResult?.artistic_features || 'Không có thông tin'}\n
                        8. Thông tin bổ sung: ${finalResult?.additional_info || 'Không có thông tin'}\n
                    `;

                    // Kiểm tra nếu tất cả các trường đều là "Không có thông tin"
                    if (!finalResult || Object.values(finalResult).every(value => value === "Không có thông tin" || !value)) {
                        const extracted_info = `
                            <h3>Thông tin bức tranh:</h3>
                            <p><strong>Tên bức tranh:</strong> ${information.title || 'Không có thông tin'}</p>
                            <p><strong>Tên nghệ sĩ:</strong> ${information.artist || 'Không có thông tin'}</p>
                            <p><strong>Phong cách:</strong> ${information.style || 'Không có thông tin'}</p>
                            <p><strong>Thể loại:</strong> ${information.genre || 'Không có thông tin'}</p>
                            <p><strong>Năm sáng tác:</strong> ${information.year || 'Không rõ'}</p>
                            <p><strong>Mô tả:</strong> ${information.description || 'Không có mô tả.'}</p>
                            <p><strong>Các đặc điểm nghệ thuật nổi bật:</strong> ${information.artistic_features || 'Không có thông tin'}</p>
                            <p><strong>Thông tin bổ sung:</strong> ${information.additional_info || 'Không có thông tin'}</p>
                        `;
                        resultContainer.innerHTML = extracted_info;
                    } else {
                        const result = `
                            <h3>Thông tin bức tranh:</h3>
                            <p><strong>Tên bức tranh:</strong> ${finalResult.title || 'Không có thông tin'}</p>
                            <p><strong>Tên nghệ sĩ:</strong> ${finalResult.artist || 'Không có thông tin'}</p>
                            <p><strong>Phong cách:</strong> ${finalResult.style || 'Không có thông tin'}</p>
                            <p><strong>Thể loại:</strong> ${finalResult.genre || 'Không có thông tin'}</p>
                            <p><strong>Năm sáng tác:</strong> ${finalResult.year || 'Không rõ'}</p>
                            <p><strong>Mô tả:</strong> ${finalResult.description || 'Không có mô tả.'}</p>
                            <p><strong>Các đặc điểm nghệ thuật nổi bật:</strong> ${finalResult.artistic_features || 'Không có thông tin'}</p>
                            <p><strong>Thông tin bổ sung:</strong> ${finalResult.additional_info || 'Không có thông tin'}</p>
                        `;
                        resultContainer.innerHTML = result;

                        // Hiển thị phần tranh luận với định dạng dễ nhìn
                        const renderDebateSection = (agentDebate, finalResult) => {
                            return `
                                <h4><strong>Phần tranh luận</strong></h4>
                                <h5><strong>Lập luận từ Gemini:</strong></h5>
                                <div>${convertMarkdownToHtml(agentDebate.gemini_debate || 'Không có lập luận từ Gemini.')}</div>
                                <h5><strong>Lập luận từ ChatGPT:</strong></h5>
                                <div>${convertMarkdownToHtml(agentDebate.chatgpt_debate || 'Không có lập luận từ ChatGPT.')}</div>
                                <h5><strong>Lý do trọng tài chọn:</strong></h5>
                                <p>${getValue(finalResult.arbitration_reason, 'Không có lý do trọng tài.')}</p>
                            `;
                        };

                        debateSection.innerHTML = renderDebateSection(agentDebate, finalResult);
                    }
                }
                backButton.style.display = 'block'; // Hiển thị nút quay lại
            })
            .catch(error => {
                loader.style.display = 'none'; // Ẩn loader khi lỗi
                submitButton.disabled = false; // Kích hoạt lại nút submit
                resultContainer.innerHTML = `<p style="color: red;">Đã có lỗi xảy ra. Vui lòng thử lại sau.</p>`;
                console.error('Error:', error);
            });
        });

        // Toggle hiển thị phần tranh luận
        debateToggle.addEventListener('click', function() {
            if (debateSection.style.display === 'none') {
                debateSection.style.display = 'block';
                debateToggle.textContent = 'Ẩn phần tranh luận';
            } else {
                debateSection.style.display = 'none';
                debateToggle.textContent = 'Xem phần tranh luận';
            }
        });

        backButton.addEventListener('click', function() {
            resultContainer.innerHTML = '';
            uploadedImageContainer.innerHTML = '';
            debateSection.style.display = 'none';
            debateToggle.textContent = 'Xem phần tranh luận';
            backButton.style.display = 'none';
            imageInput.value = '';
        });

        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
