<style>
    .process-container {
        max-width: 650px;
        background: #FFFFFF;
        border: 1px solid #D6E0DC;
        border-radius: 7px;
        padding: 25px;
        margin: 10px auto;
        color: #404040;
    }
    .process-container h3 {
        margin-top: 0;
        margin-bottom: 20px;
        padding-bottom: 8px;
        color: #5B8798;
        text-align: center;
        font-size: 20px;
        border-bottom: 1px solid #D6E0DC;
    }
    .process-container>p {
        color: #404040;
        margin-bottom: 15px;
    }
    .download-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .download-table th, .download-table td {
        border: 1px solid #D6E0DC;
        padding: 9px 12px;
        text-align: left;
    }
    .download-table th {
        background-color: #F6F8F6;
        color: #345D6B;
        font-weight: bold;
    }
    .download-table td {
        background-color: #FFFFFF;
        color: #404040;
    }
    .download-table tr:nth-child(even) td {
        background-color: #EEF3EF;
    }
    .btn-download {
        display: inline-block;
        background-color: #5B8798;
        color: #FFFFFF;
        padding: 6px 12px;
        text-decoration: none;
        border: 1px solid #5B8798;
        border-radius: 5px;
        font-family: "Times New Roman", serif;
        font-size: 13px;
        font-weight: bold;
        transition: 0.3s;
    }
    .btn-download:hover {
        background-color: #345D6B;
        border-color: #345D6B;
    }
    .btn-back {
        display: inline-block;
        margin-top: 18px;
        padding: 7px 0;
        color: #5B8798;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }
    .btn-back:hover {
        color: #345D6B;
        text-decoration: underline;
    }
    .msg-box {
        padding: 11px 13px;
        border-radius: 5px;
        margin-bottom: 15px;
        line-height: 1.5;
    }
    .msg-error {
        background-color: #F6EEEE;
        color: #7A4F4F;
        border: 1px solid #E3CCCC;
    }
    @media (max-width: 600px) {
        .process-container {
            padding: 18px;
        }
        .download-table th, .download-table td {
            padding: 7px 8px;
        }
        .btn-download {
            padding: 5px 8px;
        }
    }
</style>
<div class="process-container">
    <h3>DANH SÁCH FILE ĐÃ UPLOAD</h3>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['files'])) {
        // Cấu hình thư mục lưu file
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/CNWAT/bai_4/lay_gui_data/uploads/';
        $web_path = '/CNWAT/bai_4/lay_gui_data/uploads/';
        // Tự động tạo thư mục uploads nếu chưa có
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $uploaded_files = array();
        // Lặp qua mảng file được gửi lên
        foreach ($_FILES['files']['name'] as $i => $filename) {
            $tmp_name = $_FILES['files']['tmp_name'][$i];
            $error = $_FILES['files']['error'][$i];
            if ($error === UPLOAD_ERR_OK && !empty($filename)) {
                // Chuẩn hóa tên file an toàn
                $safe_filename = time() . '_' . basename($filename);
                $target_file = $upload_dir . $safe_filename;
                if (move_uploaded_file($tmp_name, $target_file)) {
                    $uploaded_files[] = array('name' => $filename, 'url' => $web_path . $safe_filename);
                }
            }
        }
        // Hiển thị danh sách kết quả
        if (!empty($uploaded_files)) {
            echo "<p>Upload thành công <b>" . count($uploaded_files) . "</b> file:</p>";
            echo "<table class='download-table'>";
            echo "<tr><th>STT</th><th>Tên File</th><th>Thao tác</th></tr>";
            foreach ($uploaded_files as $index => $file) {
                $stt = $index + 1;
                $fileNameEscaped = htmlspecialchars($file['name']);
                $fileUrlEscaped = htmlspecialchars($file['url']);
                echo "<tr>";
                echo "<td>{$stt}</td>";
                echo "<td>{$fileNameEscaped}</td>";
                echo "<td><a href='{$fileUrlEscaped}' class='btn-download' download>Download File</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='msg-box msg-error'>Không có file nào được tải lên thành công. Vui lòng chọn ít nhất 1 file.</div>";
        }
    } else {
        echo "<div class='msg-box msg-error'>Yêu cầu không hợp lệ hoặc chưa gửi dữ liệu file!</div>";
    }
    ?>
    <a href="index.php?page=uploadform" class="btn-back">&laquo; Quay lại trang Upload</a>
</div>