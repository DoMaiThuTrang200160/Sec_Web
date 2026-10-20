<style>
    .table-draw-container {
        max-width: 550px;
        background: #FFFFFF;
        border: 1px solid #D6E0DC;
        border-radius: 7px;
        padding: 25px;
        margin: 10px auto;
        color: #404040;
    }
    .table-draw-container h3 {
        margin-top: 0;
        margin-bottom: 22px;
        padding-bottom: 8px;
        color: #5B8798;
        text-align: center;
        font-size: 20px;
        border-bottom: 1px solid #D6E0DC;
    }
    .draw-form {
        width: 100%;
        border-collapse: collapse;
    }
    .draw-form td {
        padding: 8px 5px;
        vertical-align: middle;
    }
    .draw-form td:first-child {
        width: 110px;
        color: #345D6B;
        font-weight: bold;
    }
    .draw-form input[type="number"] {
        width: 100%;
        padding: 9px 10px;
        box-sizing: border-box;
        border: 1px solid #D6E0DC;
        border-radius: 5px;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        color: #404040;
        background-color: #FFFFFF;
        outline: none;
        transition: 0.3s;
    }
    .draw-form input[type="number"]:focus {
        border-color: #5B8798;
    }
    .draw-buttons {
        text-align: center;
        padding-top: 15px !important;
    }
    .draw-buttons button {
        padding: 9px 22px;
        margin: 0 5px;
        border-radius: 5px;
        cursor: pointer;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        font-weight: bold;
        transition: 0.3s;
    }
    .draw-buttons button[type="submit"] {
        background-color: #5B8798;
        color: #FFFFFF;
        border: 1px solid #5B8798;
    }
    .draw-buttons button[type="submit"]:hover {
        background-color: #345D6B;
        border-color: #345D6B;
    }
    .draw-buttons button[type="reset"] {
        background-color: #F6F8F6;
        color: #404040;
        border: 1px solid #D6E0DC;
    }
    .draw-buttons button[type="reset"]:hover {
        background-color: #EAF1EF;
        color: #345D6B;
        border-color: #5B8798;
    }
    .draw-note {
        margin: 15px 0 0;
        color: #6F7775;
        font-size: 13px;
        text-align: center;
    }
    .result-section {
        margin-top: 25px;
        padding-top: 18px;
        border-top: 1px solid #D6E0DC;
    }
    .result-section h4 {
        margin: 0 0 15px;
        color: #345D6B;
        font-size: 17px;
    }
    .result-table {
        border-collapse: collapse;
        margin-top: 10px;
    }
    .result-table td {
        min-width: 45px;
        height: 35px;
        border: 1px solid #D6E0DC;
        padding: 6px 12px;
        text-align: center;
        background-color: #F6F8F6;
        color: #404040;
    }
    .result-table tr:nth-child(even) td {
        background-color: #EEF3EF;
    }
    .error-message {
        color: #7A4F4F;
        background-color: #F6EEEE;
        border: 1px solid #E3CCCC;
        padding: 10px 12px;
        border-radius: 5px;
        margin-top: 15px;
        line-height: 1.5;
    }
</style>
<?php
// Khởi tạo các biến lưu giữ giá trị nhập
$sodong = isset($_POST['sodong']) ? (int) $_POST['sodong'] : '';
$socot = isset($_POST['socot']) ? (int) $_POST['socot'] : '';
?>
<div class="table-draw-container">
    <h3>FORM VẼ BẢNG</h3>
    <form method="POST" action="">
        <table class="draw-form">
            <tr>
                <td>
                    <label for="sodong">Số dòng:</label>
                </td>
                <td>
                    <input type="number" id="sodong" name="sodong" min="1" value="<?php echo htmlspecialchars((string) $sodong); ?>" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="socot">Số cột:</label>
                </td>
                <td>
                    <input type="number" id="socot" name="socot" min="1" value="<?php echo htmlspecialchars((string) $socot); ?>" required>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="draw-buttons">
                    <button type="reset">Nhập Lại</button>
                    <button type="submit" name="btnVe">Vẽ</button>
                </td>
            </tr>
        </table>
        <p class="draw-note">
            <i>(Khi Click nút Vẽ thì mới vẽ bảng và hiển thị bên dưới)</i>
        </p>
    </form>
    <?php
    // Kiểm tra khi người dùng nhấn nút "Vẽ"
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnVe'])) {
        echo '<div class="result-section">';
        if ($sodong > 0 && $socot > 0) {
            echo "<h4>Kết quả:</h4>";
            echo "<table class='result-table'>";
            for ($i = 1; $i <= $sodong; $i++) {
                echo "<tr>";
                for ($j = 1; $j <= $socot; $j++) {
                    echo "<td>" . $j . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='error-message'>Vui lòng nhập số dòng và số cột lớn hơn 0!</p>";
        }
        echo '</div>';
    }
    ?>
</div>