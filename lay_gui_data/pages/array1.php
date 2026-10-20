<style>
    .matrix-wrapper {
        max-width: 650px;
        background: #FFFFFF;
        border: 1px solid #D6E0DC;
        border-radius: 7px;
        padding: 25px;
        margin: 10px auto;
        color: #404040;
    }
    .matrix-wrapper h3 {
        margin-top: 0;
        margin-bottom: 22px;
        padding-bottom: 8px;
        color: #5B8798;
        text-align: center;
        font-size: 20px;
        border-bottom: 1px solid #D6E0DC;
    }
    .matrix-container {
        display: flex;
        gap: 20px;
        justify-content: space-between;
        margin-bottom: 15px;
    }
    .matrix-box {
        flex: 1;
        background: #F6F8F6;
        padding: 15px;
        border: 1px solid #D6E0DC;
        border-radius: 6px;
    }
    .matrix-box .title {
        display: block;
        font-weight: bold;
        margin-bottom: 12px;
        text-align: center;
        color: #345D6B;
    }
    .matrix-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 4px;
    }
    .matrix-table td {
        padding: 0;
    }
    .matrix-table input {
        width: 100%;
        text-align: center;
        padding: 7px 2px;
        border: 1px solid #D6E0DC;
        border-radius: 5px;
        box-sizing: border-box;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        color: #404040;
        background: #FFFFFF;
        outline: none;
        transition: 0.3s;
    }
    .matrix-table input:focus {
        border-color: #5B8798;
    }
    .btn-group {
        text-align: center;
        margin-top: 20px;
    }
    .btn-group input {
        padding: 9px 20px;
        margin: 0 5px;
        border-radius: 5px;
        cursor: pointer;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        font-weight: bold;
        transition: 0.3s;
    }
    .btn-submit {
        background-color: #5B8798;
        color: #FFFFFF;
        border: 1px solid #5B8798;
    }
    .btn-submit:hover {
        background-color: #345D6B;
        border-color: #345D6B;
    }
    .btn-reset {
        background-color: #F6F8F6;
        color: #404040;
        border: 1px solid #D6E0DC;
    }
    .btn-reset:hover {
        background-color: #EAF1EF;
        color: #345D6B;
    }
    .result-section {
        margin-top: 25px;
        padding-top: 18px;
        border-top: 1px solid #D6E0DC;
    }
    .result-section h4 {
        margin: 0 0 15px 0 !important;
        color: #5B8798 !important;
        font-size: 17px;
    }
    .result-tables {
        display: flex;
        gap: 15px;
        justify-content: space-around;
        margin-top: 10px;
    }
    .res-box {
        text-align: center;
        color: #345D6B;
    }
    .res-box>b {
        display: block;
        margin-bottom: 7px;
    }
    .res-table {
        border-collapse: collapse;
        margin: 0 auto;
    }
    .res-table td {
        border: 1px solid #D6E0DC;
        background: #F6F8F6;
        padding: 7px 12px;
        text-align: center;
        font-weight: bold;
        min-width: 35px;
        color: #404040;
    }
    .res-table tr:nth-child(even) td {
        background: #EEF3EF;
    }
    .error-msg {
        color: #7A4F4F;
        background-color: #F6EEEE;
        border: 1px solid #E3CCCC;
        padding: 10px 12px;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    @media (max-width: 650px) {
        .matrix-container {
            flex-direction: column;
        }
        .result-tables {
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        .matrix-wrapper {
            padding: 18px;
        }
    }
</style>
<?php
$m1 = array();
$m2 = array();
$tong = array();
$hieu = array();
$tich = array();
$msg = "";
$hien_thi_ket_qua = false;
if (isset($_POST['btnTinh'])) {
    $m1 = $_POST['m1'] ?? [];
    $m2 = $_POST['m2'] ?? [];
    $hien_thi_ket_qua = true;
    // Kiểm tra dữ liệu và tính toán
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            $val1 = $m1[$i][$j] ?? '';
            $val2 = $m2[$i][$j] ?? '';
            if (!is_numeric($val1) || !is_numeric($val2)) {
                $msg = "Vui lòng nhập đầy đủ giá trị là số cho 2 ma trận!";
                $hien_thi_ket_qua = false;
                break 2;
            }
            // Ép kiểu dữ liệu sang float
            $num1 = floatval($val1);
            $num2 = floatval($val2);
            // 1. Tính Tổng
            $tong[$i][$j] = $num1 + $num2;
            // 2. Tính Hiệu
            $hieu[$i][$j] = $num1 - $num2;
            // 3. Tính Tích (M1 x M2)
            $tich[$i][$j] = 0;
            for ($k = 0; $k < 3; $k++) {
                $item1 = floatval($m1[$i][$k] ?? 0);
                $item2 = floatval($m2[$k][$j] ?? 0);
                $tich[$i][$j] += $item1 * $item2;
            }
        }
    }
}
?>
<div class="matrix-wrapper">
    <h3>SỬ DỤNG MẢNG ĐỂ TÍNH: TỔNG, HIỆU, TÍCH 2 MA TRẬN</h3>
    <?php if ($msg !== ""): ?>
        <div class="error-msg">
            <?php echo htmlspecialchars($msg); ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="matrix-container">
            <!-- Ma trận 1 -->
            <div class="matrix-box">
                <span class="title">Nhập Ma trận 1 (3x3)</span>
                <table class="matrix-table">
                    <?php
                    for ($i = 0; $i < 3; $i++) {
                        echo "<tr>";
                        for ($j = 0; $j < 3; $j++) {
                            $val = isset($m1[$i][$j]) ? htmlspecialchars((string) $m1[$i][$j]) : "";
                            echo "<td>";
                            echo "<input type='number' step='any' name='m1[$i][$j]' value='$val' required>";
                            echo "</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
            <!-- Ma trận 2 -->
            <div class="matrix-box">
                <span class="title">Nhập Ma trận 2 (3x3)</span>
                <table class="matrix-table">
                    <?php
                    for ($i = 0; $i < 3; $i++) {
                        echo "<tr>";
                        for ($j = 0; $j < 3; $j++) {
                            $val = isset($m2[$i][$j]) ? htmlspecialchars((string) $m2[$i][$j]) : "";
                            echo "<td>";
                            echo "<input type='number' step='any' name='m2[$i][$j]' value='$val' required>";
                            echo "</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
        <!-- Nút -->
        <div class="btn-group">
            <input type="submit" name="btnTinh" class="btn-submit" value="Tính Toán">
            <input type="button" class="btn-reset" value="Nhập Lại" onclick="window.location.href='index.php?page=array1'">
        </div>
    </form>
    <!-- Kết quả -->
    <?php if ($hien_thi_ket_qua): ?>
        <div class="result-section">
            <h4>KẾT QUẢ:</h4>
            <div class="result-tables">
                <?php
                // Hàm hỗ trợ render ma trận kết quả dạng Bảng HTML
                function renderMatrixTable($label, $matrix)
                {
                    echo "<div class='res-box'>";
                    echo "<b>$label</b>";
                    echo "<table class='res-table'>";
                    for ($i = 0; $i < 3; $i++) {
                        echo "<tr>";
                        for ($j = 0; $j < 3; $j++) {
                            echo "<td>";
                            echo htmlspecialchars((string) $matrix[$i][$j]);
                            echo "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
                renderMatrixTable("Ma trận Tổng", $tong);
                renderMatrixTable("Ma trận Hiệu", $hieu);
                renderMatrixTable("Ma trận Tích", $tich);
                ?>
            </div>
        </div>
    <?php endif; ?>
</div>