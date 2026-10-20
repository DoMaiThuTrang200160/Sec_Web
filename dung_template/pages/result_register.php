<div class="result-page">
    <h3>Kết quả đăng ký</h3>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ten = isset($_POST['ten']) ? $_POST['ten'] : "";
        $diachi = isset($_POST['dia_chi']) ? $_POST['dia_chi'] : "";
        $nghe = $_POST['nghe'] ?? '';
        $ghichu = $_POST['ghi_chu'] ?? '';
        echo "<div class='register-result'>";
        echo "<div class='result-row'>";
        echo "<span>Tên</span>";
        echo "<strong>" . htmlspecialchars($ten) . "</strong>";
        echo "</div>";
        echo "<div class='result-row'>";
        echo "<span>Địa chỉ</span>";
        echo "<strong>" . htmlspecialchars($diachi) . "</strong>";
        echo "</div>";
        echo "<div class='result-row'>";
        echo "<span>Nghề</span>";
        echo "<strong>" . htmlspecialchars($nghe) . "</strong>";
        echo "</div>";
        echo "<div class='result-row'>";
        echo "<span>Ghi chú</span>";
        echo "<strong>" . htmlspecialchars($ghichu) . "</strong>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "<p class='no-data'>Chưa có dữ liệu đăng ký.</p>";
    }
    ?>
</div>