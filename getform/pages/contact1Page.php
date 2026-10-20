<style>
    .contact-container {
        max-width: 600px;
        background: #FFFFFF;
        border: 1px solid #D6E0DC;
        border-radius: 7px;
        padding: 25px;
        margin: 20px auto;
        font-family: "Times New Roman", serif;
        color: #404040;
    }
    .contact-container h3 {
        text-align: center;
        margin-top: 0;
        color: #345D6B;
        border-bottom: 2px solid #5B8798;
        padding-bottom: 10px;
    }
    .form-table {
        width: 100%;
        border-collapse: collapse;
    }
    .form-table td {
        padding: 8px 5px;
        vertical-align: top;
    }
    .form-table td:first-child {
        width: 30%;
        font-weight: bold;
        color: #345D6B;
    }
    .form-table input[type="text"], .form-table input[type="email"], .form-table select, .form-table textarea {
        width: 100%;
        padding: 7px 10px;
        border: 1px solid #D6E0DC;
        border-radius: 5px;
        box-sizing: border-box;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        color: #404040;
        background-color: #FFFFFF;
    }
    .form-table input[type="text"]:focus, .form-table input[type="email"]:focus, .form-table select:focus, .form-table textarea:focus {
        outline: none;
        border-color: #5B8798;
    }
    .form-table input[type="radio"] {
        accent-color: #5B8798;
    }
    .btn-group {
        text-align: center;
        padding-top: 15px;
    }
    .btn-group input {
        padding: 8px 20px;
        margin: 0 5px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-family: "Times New Roman", serif;
        font-weight: bold;
        transition: 0.3s;
    }
    .btn-submit {
        background-color: #5B8798;
        color: #FFFFFF;
    }
    .btn-submit:hover {
        background-color: #345D6B;
    }
    .btn-reset {
        background-color: #6F7775;
        color: #FFFFFF;
    }
    .btn-reset:hover {
        background-color: #555D5B;
    }
    .result-box {
        margin-top: 20px;
        background: #F6F8F6;
        border: 1px solid #D6E0DC;
        border-radius: 6px;
        padding: 15px;
    }
    .result-box h4 {
        margin-top: 0;
        color: #5B8798;
        border-bottom: 1px solid #D6E0DC;
        padding-bottom: 5px;
    }
    .result-table {
        width: 100%;
        border-collapse: collapse;
    }
    .result-table td {
        padding: 6px 0;
    }
    .result-table td:first-child {
        width: 30%;
        font-weight: bold;
        color: #345D6B;
    }
</style>
<div class="contact-container">
    <h3>FORM LIÊN HỆ</h3>
    <form name="formContact" action="index.php?page=contact1Page" method="POST">
        <table class="form-table">
            <tr>
                <td><label for="txtName">Họ và tên:</label></td>
                <td>
                    <input name="txtName" type="text" id="txtName" required value="<?php echo htmlspecialchars($_POST['txtName'] ?? ''); ?>">
                </td>
            </tr>
            <tr>
                <td><label for="txtEmail">Email:</label></td>
                <td>
                    <input name="txtEmail" type="email" id="txtEmail" required value="<?php echo htmlspecialchars($_POST['txtEmail'] ?? ''); ?>">
                </td>
            </tr>
            <tr>
                <td><label for="txtPhone">Số điện thoại:</label></td>
                <td>
                    <input name="txtPhone" type="text" id="txtPhone" value="<?php echo htmlspecialchars($_POST['txtPhone'] ?? ''); ?>">
                </td>
            </tr>
            <tr>
                <td><label for="lstTopic">Chủ đề liên hệ:</label></td>
                <td>
                    <?php $selectedTopic = $_POST['lstTopic'] ?? ''; ?>
                    <select name="lstTopic" id="lstTopic">
                        <option value="">-- Chọn chủ đề --</option>
                        <option value="Góp ý" <?php if ($selectedTopic === 'Góp ý') echo 'selected'; ?>>Góp ý</option>
                        <option value="Hỏi đáp" <?php if ($selectedTopic === 'Hỏi đáp') echo 'selected'; ?>>Hỏi đáp</option>
                        <option value="Báo lỗi" <?php if ($selectedTopic === 'Báo lỗi') echo 'selected'; ?>>Báo lỗi hệ thống</option>
                        <option value="Hợp tác" <?php if ($selectedTopic === 'Hợp tác') echo 'selected'; ?>>Hợp tác kinh doanh</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Kênh phản hồi:</td>
                <td>
                    <?php $selectedChannel = $_POST['radChannel'] ?? ''; ?>
                    <label>
                        <input type="radio" name="radChannel" value="Email" <?php if ($selectedChannel === 'Email') echo 'checked'; ?>>Email
                    </label>
                    &nbsp;
                    <label>
                        <input type="radio" name="radChannel" value="Điện thoại" <?php if ($selectedChannel === 'Điện thoại') echo 'checked'; ?>>Điện thoại
                    </label>
                </td>
            </tr>
            <tr>
                <td><label for="taMessage">Nội dung liên hệ:</label></td>
                <td>
                    <textarea name="taMessage" id="taMessage" rows="4" required><?php echo htmlspecialchars($_POST['taMessage'] ?? ''); ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="btn-group">
                    <input type="reset" name="btnReset" value="Nhập lại" class="btn-reset">
                    <input type="submit" name="btnSend" id="btnSend" value="Gửi liên hệ" class="btn-submit">
                </td>
            </tr>
        </table>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnSend'])) {
        $name = htmlspecialchars($_POST['txtName'] ?? '');
        $email = htmlspecialchars($_POST['txtEmail'] ?? '');
        $phone = htmlspecialchars($_POST['txtPhone'] ?? 'Chưa cung cấp');
        $topic = htmlspecialchars($_POST['lstTopic'] ?? '');
        $channel = htmlspecialchars($_POST['radChannel'] ?? '');
        $message = nl2br(htmlspecialchars($_POST['taMessage'] ?? ''));
        ?>
        <div class="result-box">
            <h4>NỘI DUNG LIÊN HỆ ĐÃ GỬI</h4>
            <table class="result-table">
                <tr>
                    <td>Họ và tên:</td>
                    <td><b><?php echo $name; ?></b></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?php echo $email; ?></td>
                </tr>
                <tr>
                    <td>Số điện thoại:</td>
                    <td><?php echo $phone; ?></td>
                </tr>
                <tr>
                    <td>Chủ đề:</td>
                    <td><?php echo $topic; ?></td>
                </tr>
                <tr>
                    <td>Ưu tiên phản hồi qua:</td>
                    <td><?php echo $channel; ?></td>
                </tr>
                <tr>
                    <td>Nội dung:</td>
                    <td><?php echo $message; ?></td>
                </tr>
            </table>
        </div>
        <?php
    }
    ?>
</div>