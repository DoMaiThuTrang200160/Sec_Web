<style>
    .register-container {
        max-width: 600px;
        background: #FFFFFF;
        border: 1px solid #D6E0DC;
        border-radius: 7px;
        padding: 25px;
        margin: 20px auto;
    }
    .register-container h3 {
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
        width: 35%;
        font-weight: bold;
        color: #345D6B;
    }
    .form-table input[type="text"], .form-table input[type="password"], .form-table select, .form-table textarea {
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
    .form-table input[type="text"]:focus, .form-table input[type="password"]:focus, .form-table select:focus, .form-table textarea:focus {
        outline: none;
        border-color: #5B8798;
    }
    .checkbox-group, .radio-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .checkbox-group label, .radio-group label {
        font-weight: normal;
        cursor: pointer;
    }
    .checkbox-group input[type="checkbox"], .radio-group input[type="radio"], .form-table input[type="checkbox"] {
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
</style>
<div class="register-container">
    <h3>FORM ĐĂNG KÝ</h3>
    <form name="form1" action="index.php?page=registerProcess" method="POST">
        <table class="form-table">
            <tr>
                <td><label for="txtUsername">Username:</label></td>
                <td>
                    <input name="txtUsername" type="text" id="txtUsername" required>
                </td>
            </tr>
            <tr>
                <td><label for="txtPassword">Password:</label></td>
                <td>
                    <input name="txtPassword" type="password" id="txtPassword" required>
                </td>
            </tr>
            <tr>
                <td>Giới tính:</td>
                <td>
                    <div class="radio-group">
                        <label><input type="radio" name="radGender" value="Male"> Nam (Male)</label>
                        <label><input type="radio" name="radGender" value="Female"> Nữ (Female)</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="lstAddress">Địa chỉ:</label></td>
                <td>
                    <select name="lstAddress" id="lstAddress" required>
                        <option value="">-- Chọn địa chỉ --</option>
                        <option value="Hà Nội">Hà Nội</option>
                        <option value="TP. HCM">TP. HCM</option>
                        <option value="Huế">Huế</option>
                        <option value="Đà Nẵng">Đà Nẵng</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Ngôn ngữ lập trình thành thạo:</td>
                <td>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="chkLang[]" value="PHP"> PHP</label>
                        <label><input type="checkbox" name="chkLang[]" value="C#"> C#</label>
                        <label><input type="checkbox" name="chkLang[]" value="Java"> Java</label>
                        <label><input type="checkbox" name="chkLang[]" value="C++"> C++</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Kỹ năng (Skill):</td>
                <td>
                    <div class="radio-group">
                        <label><input type="radio" name="radSkill" value="Normal"> Bình thường (Normal)</label>
                        <label><input type="radio" name="radSkill" value="Good"> Tốt (Good)</label>
                        <label><input type="radio" name="radSkill" value="Very Good"> Rất tốt (Very Good)</label>
                        <label><input type="radio" name="radSkill" value="Excellent"> Xuất sắc (Excellent)</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="taNote">Ghi chú (Note):</label></td>
                <td>
                    <textarea name="taNote" id="taNote" rows="3" cols="40"></textarea>
                </td>
            </tr>
            <tr>
                <td>Tình trạng hôn nhân:</td>
                <td>
                    <label>
                        <input type="checkbox" name="chkMariageStatus" id="chkMariageStatus" value="Đã kết hôn"> Đã kết hôn
                    </label>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="btn-group">
                    <input type="reset" name="btnReset" value="Reset" class="btn-reset">
                    <input type="submit" name="btnRegister" id="btnRegister" value="Register" class="btn-submit">
                </td>
            </tr>
        </table>
    </form>
</div>