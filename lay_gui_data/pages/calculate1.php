<style>
    .calc-container {
        max-width: 450px;
        background: #FFFFFF;
        border: 1px solid #D6E0DC;
        border-radius: 7px;
        padding: 25px;
        margin: 10px auto;
        color: #404040;
    }
    .calc-container h3 {
        margin-top: 0;
        margin-bottom: 22px;
        padding-bottom: 8px;
        color: #5B8798;
        text-align: center;
        font-size: 20px;
        border-bottom: 1px solid #D6E0DC;
    }
    .form-group {
        margin-bottom: 18px;
    }
    .form-group label {
        display: block;
        margin-bottom: 7px;
        color: #345D6B;
        font-weight: bold;
    }
    .form-group input[type="number"] {
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
    .form-group input[type="number"]:focus {
        border-color: #5B8798;
    }
    .radio-group {
        display: flex;
        gap: 10px;
        margin: 10px 0;
    }
    .radio-group label {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 42px;
        padding: 7px 10px;
        margin: 0;
        color: #404040;
        background-color: #F6F8F6;
        border: 1px solid #D6E0DC;
        border-radius: 5px;
        cursor: pointer;
        font-weight: normal;
        transition: 0.3s;
    }
    .radio-group label:hover {
        color: #345D6B;
        background-color: #EAF1EF;
        border-color: #5B8798;
    }
    .radio-group input[type="radio"] {
        margin-right: 5px;
        accent-color: #5B8798;
    }
    .btn-submit {
        display: block;
        margin: 5px auto 0;
        background-color: #5B8798;
        color: #FFFFFF;
        border: 1px solid #5B8798;
        padding: 9px 22px;
        border-radius: 5px;
        cursor: pointer;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        font-weight: bold;
        transition: 0.3s;
    }
    .btn-submit:hover {
        background-color: #345D6B;
        border-color: #345D6B;
    }
    .result-box {
        margin-top: 20px;
        padding: 13px 15px;
        border: 1px solid #D6E0DC;
        border-radius: 5px;
        background-color: #F6F8F6;
        color: #404040;
        line-height: 1.5;
    }
    .result-box strong {
        color: #345D6B;
    }
    .result-box.error {
        background-color: #F6EEEE;
        color: #7A4F4F;
        border-color: #E3CCCC;
    }
    .result-box.error strong {
        color: #7A4F4F;
    }
</style>
<?php
$result = '';
$isError = false;
// Giữ lại giá trị nhập của người dùng
$a = isset($_POST['a']) ? filter_var($_POST['a'], FILTER_VALIDATE_INT) : '';
$b = isset($_POST['b']) ? filter_var($_POST['b'], FILTER_VALIDATE_INT) : '';
$operator = $_POST['operator'] ?? '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($a === false || $b === false) {
        $result = "Vui lòng nhập hai số nguyên hợp lệ.";
        $isError = true;
    } elseif (empty($operator)) {
        $result = "Vui lòng chọn phép tính.";
        $isError = true;
    } else {
        switch ($operator) {
            case '+':
                $result = "$a + $b = " . ($a + $b);
                break;
            case '-':
                $result = "$a - $b = " . ($a - $b);
                break;
            case '*':
                $result = "$a * $b = " . ($a * $b);
                break;
            case '/':
                if ($b === 0) {
                    $result = "Không thể chia cho 0!";
                    $isError = true;
                } else {
                    $result = "$a / $b = " . ($a / $b);
                }
                break;
            default:
                $result = "Phép tính không hợp lệ.";
                $isError = true;
        }
    }
}
?>
<div class="calc-container">
    <h3>Tính toán đơn giản</h3>
    <form method="POST" action="">
        <div class="form-group">
            <label for="num_a">Số a:</label>
            <input type="number" id="num_a" name="a" step="1" value="<?php echo htmlspecialchars((string) $a); ?>" required>
        </div>
        <div class="form-group">
            <label for="num_b">Số b:</label>
            <input type="number" id="num_b" name="b" step="1" value="<?php echo htmlspecialchars((string) $b); ?>" required>
        </div>
        <div class="form-group">
            <label>Chọn phép tính:</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="operator" value="+" <?php echo ($operator === '+') ? 'checked' : ''; ?> required>
                    +
                </label>
                <label>
                    <input type="radio" name="operator" value="-" <?php echo ($operator === '-') ? 'checked' : ''; ?>>
                    -
                </label>
                <label>
                    <input type="radio" name="operator" value="*" <?php echo ($operator === '*') ? 'checked' : ''; ?>>
                    *
                </label>
                <label>
                    <input type="radio" name="operator" value="/" <?php echo ($operator === '/') ? 'checked' : ''; ?>>
                    /
                </label>
            </div>
        </div>
        <button type="submit" class="btn-submit">Calculate</button>
    </form>
    <?php if ($result !== ''): ?>
        <div class="result-box <?php echo $isError ? 'error' : ''; ?>">
            <strong>Kết quả: </strong>
            <?php echo htmlspecialchars($result); ?>
        </div>
    <?php endif; ?>
</div>