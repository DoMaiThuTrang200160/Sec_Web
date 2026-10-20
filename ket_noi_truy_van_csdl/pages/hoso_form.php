<?php
global $conn;
$id = "";
$hoten = "";
$ngaysinh = "";
$diachi = "";
$malop_selected = "";
$dtoan = "";
$dly = "";
$dhoa = "";
$is_edit = false;
// 1. Lấy danh sách Lớp cho thẻ <select>
$sql_lops = "SELECT MALOP, TENLOP FROM LOP";
$res_lops = mysqli_query($conn, $sql_lops);
// 2. Chế độ Sửa nếu có ?id=
if (isset($_GET['id'])) {
    $is_edit = true;
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM HOSO WHERE MAHS = '$id'";
    $res = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($res)) {
        $hoten          = $row['HOTEN'];
        $ngaysinh       = $row['NGAYSINH'];
        $diachi         = $row['DIACHI'];
        $malop_selected = $row['LOP'];
        $dtoan          = $row['DIEMTOAN'];
        $dly            = $row['DIEMLY'];
        $dhoa           = $row['DIEMHOA'];
    }
}
// 3. Xử lý submit
if (isset($_POST['btnLuuHS'])) {
    $mahs_in     = trim($_POST['mahs']);
    $hoten_in    = trim($_POST['hoten']);
    $ngaysinh_in = trim($_POST['ngaysinh']);
    $diachi_in   = trim($_POST['diachi']);
    $malop_in    = trim($_POST['malop']);
    $dtoan_in    = floatval($_POST['dtoan']);
    $dly_in      = floatval($_POST['dly']);
    $dhoa_in     = floatval($_POST['dhoa']);
    if ($is_edit) {
        $sql_save = "UPDATE HOSO 
                     SET HOTEN='$hoten_in',
                         NGAYSINH='$ngaysinh_in',
                         DIACHI='$diachi_in',
                         LOP='$malop_in',
                         DIEMTOAN=$dtoan_in,
                         DIEMLY=$dly_in,
                         DIEMHOA=$dhoa_in
                     WHERE MAHS='$id'";
    } else {
        $sql_save = "INSERT INTO HOSO
                     VALUES ('$mahs_in',
                             '$hoten_in',
                             '$ngaysinh_in',
                             '$diachi_in',
                             '$malop_in',
                             $dtoan_in,
                             $dly_in,
                             $dhoa_in)";
    }
    if (mysqli_query($conn, $sql_save)) {
        echo "<script>
                alert('Lưu dữ liệu Hồ sơ học sinh thành công!');
                window.location.href='index.php?page=hoso_list';
              </script>";
    } else {
        $err = mysqli_error($conn);
        echo "<script>
                alert('Lỗi CSDL: " . addslashes($err) . "');
              </script>";
    }
}
?>
<h3>
    <?php echo $is_edit ? "SỬA HỒ SƠ HỌC SINH" : "THÊM HỌC SINH MỚI"; ?>
</h3>
<form method="POST" action="">
    <table class="db-form-table">
        <tr>
            <td>Mã HS:</td>
            <td>
                <input
                    type="text"
                    name="mahs"
                    value="<?php echo $is_edit ? htmlspecialchars($id) : ''; ?>"
                    <?php echo $is_edit ? 'readonly' : ''; ?>
                    required
                >
            </td>
        </tr>
        <tr>
            <td>Họ và Tên:</td>
            <td>
                <input
                    type="text"
                    name="hoten"
                    value="<?php echo htmlspecialchars($hoten); ?>"
                    required
                >
            </td>
        </tr>
        <tr>
            <td>Ngày Sinh:</td>
            <td>
                <input
                    type="date"
                    name="ngaysinh"
                    value="<?php echo htmlspecialchars($ngaysinh); ?>"
                    required
                >
            </td>
        </tr>
        <tr>
            <td>Địa Chỉ:</td>
            <td>
                <input
                    type="text"
                    name="diachi"
                    value="<?php echo htmlspecialchars($diachi); ?>"
                    required
                >
            </td>
        </tr>
        <tr>
            <td>Lớp Học:</td>
            <td>
                <select name="malop" required>
                    <option value="">-- Chọn Lớp --</option>

                    <?php if ($res_lops && mysqli_num_rows($res_lops) > 0): ?>
                        <?php while ($l = mysqli_fetch_assoc($res_lops)): ?>
                            <option
                                value="<?php echo htmlspecialchars($l['MALOP']); ?>"
                                <?php echo ($l['MALOP'] == $malop_selected) ? 'selected' : ''; ?>
                            >
                                <?php echo htmlspecialchars($l['MALOP'] . " - " . $l['TENLOP']); ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Điểm Toán:</td>
            <td>
                <input
                    type="number"
                    step="0.1"
                    min="0"
                    max="10"
                    name="dtoan"
                    value="<?php echo htmlspecialchars($dtoan); ?>"
                    required
                >
            </td>
        </tr>
        <tr>
            <td>Điểm Lý:</td>
            <td>
                <input
                    type="number"
                    step="0.1"
                    min="0"
                    max="10"
                    name="dly"
                    value="<?php echo htmlspecialchars($dly); ?>"
                    required
                >
            </td>
        </tr>
        <tr>
            <td>Điểm Hóa:</td>
            <td>
                <input
                    type="number"
                    step="0.1"
                    min="0"
                    max="10"
                    name="dhoa"
                    value="<?php echo htmlspecialchars($dhoa); ?>"
                    required
                >
            </td>
        </tr>
        <tr>
            <td></td>
            <td class="form-buttons">
                <input type="submit" name="btnLuuHS" value="Lưu Hồ Sơ">
                <a href="index.php?page=hoso_list">
                    <input type="button" value="Hủy">
                </a>
            </td>
        </tr>
    </table>
</form>