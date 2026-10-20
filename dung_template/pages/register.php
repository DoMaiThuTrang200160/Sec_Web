<div class="register-page">
    <h3>Form đăng ký</h3>
    <form action="index.php?page=result_register" method="POST">
        <table class="register-table">
            <tr>
                <td>Tên:</td>
                <td>
                    <input type="text" name="ten" size="30">
                </td>
            </tr>
            <tr>
                <td>Địa chỉ:</td>
                <td>
                    <input type="text" name="dia_chi" size="30">
                </td>
            </tr>
            <tr>
                <td>Nghề:</td>
                <td>
                    <input type="text" name="nghe" size="30">
                </td>
            </tr>
            <tr>
                <td>Ghi chú:</td>
                <td>
                    <textarea name="ghi_chu" rows="3" cols="32"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="form-buttons">
                    <input type="reset" value="Xóa">
                    <input type="submit" value="Đăng ký">
                </td>
            </tr>
        </table>
    </form>
</div>