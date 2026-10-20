<style>
    .form-container {
        max-width: 450px;
        background: #FFFFFF;
        border: 1px solid #D6E0DC;
        border-radius: 7px;
        padding: 25px;
        margin: 10px auto;
        color: #404040;
    }
    .form-container h3 {
        text-align: center;
        margin-top: 0;
        margin-bottom: 22px;
        padding-bottom: 8px;
        color: #5B8798;
        font-size: 20px;
        border-bottom: 1px solid #D6E0DC;
    }
    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    .form-group label {
        width: 100px;
        margin-right: 10px;
        color: #345D6B;
        font-weight: bold;
    }
    .form-group input {
        flex: 1;
        padding: 9px 10px;
        border: 1px solid #D6E0DC;
        border-radius: 5px;
        box-sizing: border-box;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        color: #404040;
        background-color: #FFFFFF;
        outline: none;
        transition: 0.3s;
    }
    .form-group input:focus {
        border-color: #5B8798;
    }
    .form-group input[readonly] {
        background-color: #F6F8F6;
        font-weight: bold;
        color: #345D6B;
        cursor: default;
    }
    .buttons {
        text-align: center;
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid #D6E0DC;
    }
    .buttons input[type="submit"], .buttons input[type="button"] {
        padding: 9px 22px;
        margin: 0 5px;
        border-radius: 5px;
        cursor: pointer;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        font-weight: bold;
        transition: 0.3s;
    }
    .buttons input[type="submit"] {
        background-color: #5B8798;
        color: #FFFFFF;
        border: 1px solid #5B8798;
    }
    .buttons input[type="submit"]:hover {
        background-color: #345D6B;
        border-color: #345D6B;
    }
    .buttons input[type="button"] {
        background-color: #F6F8F6;
        color: #404040;
        border: 1px solid #D6E0DC;
    }
    .buttons input[type="button"]:hover {
        background-color: #EAF1EF;
        color: #345D6B;
        border-color: #5B8798;
    }
    .error-msg {
        color: #7A4F4F;
        background-color: #F6EEEE;
        border: 1px solid #E3CCCC;
        padding: 10px 12px;
        border-radius: 5px;
        margin-bottom: 18px;
        line-height: 1.5;
    }
    @media (max-width: 600px) {
        .form-container {
            padding: 18px;
        }
        .form-group {
            display: block;
        }
        .form-group label {
            display: block;
            width: auto;
            margin-bottom: 7px;
        }
        .form-group input {
            width: 100%;
        }
    }
</style>
<?php
$hovaten = "";
$lop = "";
$m1 = "";
$m2 = "";
$m3 = "";
$tongdiem = "";
$msg = "";
if (isset($_POST['ok'])) {
    $hovaten = trim($_POST['hovaten'] ?? '');
    $lop = trim($_POST['lop'] ?? '');
    $m1 = trim($_POST['m1'] ?? '');
    $m2 = trim($_POST['m2'] ?? '');
    $m3 = trim($_POST['m3'] ?? '');
    // 1. Kiểm tra rỗng
    if ($hovaten === "" || $lop === "" || $m1 === "" || $m2 === "" || $m3 === "") {
        $msg = "Vui lòng nhập đầy đủ thông tin!";
    }
    // 2. Kiểm tra dữ liệu số
    elseif (!is_numeric($m1) || !is_numeric($m2) || !is_numeric($m3)) {
        $msg = "Điểm M1, M2, M3 phải là số!";
    }
    // 3. Kiểm tra miền giá trị điểm (0 đến 10)
    elseif ($m1 < 0 || $m1 > 10 || $m2 < 0 || $m2 > 10 || $m3 < 0 || $m3 > 10) {
        $msg = "Điểm M1, M2, M3 phải nằm trong khoảng từ 0 đến 10!";
    } else {
        // 4. Tính tổng điểm
        $sum = floatval($m1) + floatval($m2) + floatval($m3);
        $tongdiem = round($sum, 2);
    }
}
?>
<div class="form-container">
    <h3>BẢNG ĐIỂM</h3>
    <?php if ($msg !== ""): ?>
        <div class="error-msg">
            <?php echo htmlspecialchars($msg); ?>
        </div>
    <?php endif; ?>
    <form action="" method="POST">
        <div class="form-group">
            <label for="hovaten">Họ và tên</label>
            <input type="text" id="hovaten" name="hovaten" value="<?php echo htmlspecialchars($hovaten); ?>" required>
        </div>
        <div class="form-group">
            <label for="lop">Lớp</label>
            <input type="text" id="lop" name="lop" value="<?php echo htmlspecialchars($lop); ?>" required>
        </div>
        <div class="form-group">
            <label for="m1">Điểm M1</label>
            <input type="number" id="m1" name="m1" step="0.1" min="0" max="10" value="<?php echo htmlspecialchars((string) $m1); ?>" required>
        </div>
        <div class="form-group">
            <label for="m2">Điểm M2</label>
            <input type="number" id="m2" name="m2" step="0.1" min="0" max="10" value="<?php echo htmlspecialchars((string) $m2); ?>" required>
        </div>
        <div class="form-group">
            <label for="m3">Điểm M3</label>
            <input type="number" id="m3" name="m3" step="0.1" min="0" max="10" value="<?php echo htmlspecialchars((string) $m3); ?>" required>
        </div>
        <div class="form-group">
            <label for="tongdiem">Tổng điểm</label>
            <input type="text" id="tongdiem" name="tongdiem" value="<?php echo htmlspecialchars((string) $tongdiem); ?>" readonly>
        </div>
        <div class="buttons">
            <input type="submit" name="ok" value="OK">
            <input type="button" value="Cancel" onclick="window.location.href='index.php?page=calculate2'">
        </div>
    </form>
</div>