<style>
    .result-container {
        max-width: 600px;
        background: #FFFFFF;
        border: 1px solid #D6E0DC;
        border-radius: 7px;
        padding: 25px;
        margin: 10px 0;
        font-family: "Times New Roman", serif;
        color: #404040;
    }
    .result-container h3 {
        color: #345D6B;
        margin-top: 0;
        border-bottom: 2px solid #5B8798;
        padding-bottom: 8px;
    }
    .info-table {
        width: 100%;
        border-collapse: collapse;
    }
    .info-table td {
        padding: 8px 5px;
        border-bottom: 1px dashed #D6E0DC;
        vertical-align: top;
    }
    .info-table td:first-child {
        width: 35%;
        font-weight: bold;
        color: #345D6B;
    }
    .result-container a {
        color: #5B8798;
        text-decoration: none;
        font-weight: bold;
    }
    .result-container a:hover {
        color: #345D6B;
        text-decoration: underline;
    }
    .result-container p {
        color: #8A5A5A;
    }
</style>
<div class="result-container">
    <h3>THÔNG TIN ĐĂNG KÝ NHẬN ĐƯỢC</h3>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars($_POST['txtUsername'] ?? '');
        $password = htmlspecialchars($_POST['txtPassword'] ?? '');
        $gender = htmlspecialchars($_POST['radGender'] ?? 'Chưa chọn');
        $address = htmlspecialchars($_POST['lstAddress'] ?? '');
        $skills = htmlspecialchars($_POST['radSkill'] ?? 'Chưa chọn');
        $note = nl2br(htmlspecialchars($_POST['taNote'] ?? ''));
        // Checkbox đơn giá trị
        $marriage = isset($_POST['chkMariageStatus']) ? htmlspecialchars($_POST['chkMariageStatus']) : 'Độc thân / Chưa kết hôn';
        // Checkbox List (mảng)
        $languages = isset($_POST['chkLang']) && is_array($_POST['chkLang'])
            ? implode(', ', array_map('htmlspecialchars', $_POST['chkLang']))
            : 'Chưa chọn ngôn ngữ nào';
        ?>
        <table class="info-table">
            <tr>
                <td>Username:</td>
                <td><b><?php echo $username; ?></b></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><?php echo str_repeat('*', strlen($password)); ?></td>
            </tr>
            <tr>
                <td>Giới tính:</td>
                <td><?php echo $gender; ?></td>
            </tr>
            <tr>
                <td>Địa chỉ:</td>
                <td><?php echo $address; ?></td>
            </tr>
            <tr>
                <td>Ngôn ngữ lập trình:</td>
                <td><?php echo $languages; ?></td>
            </tr>
            <tr>
                <td>Kỹ năng:</td>
                <td><?php echo $skills; ?></td>
            </tr>
            <tr>
                <td>Ghi chú:</td>
                <td><?php echo $note; ?></td>
            </tr>
            <tr>
                <td>Tình trạng hôn nhân:</td>
                <td><?php echo $marriage; ?></td>
            </tr>
        </table>
        <?php
    } else {
        echo "<p style='color:red;'>Yêu cầu không hợp lệ!</p>";
    }
    ?>
    <br>
    <a href="index.php?page=register">&laquo; Quay lại trang đăng ký</a>
</div>