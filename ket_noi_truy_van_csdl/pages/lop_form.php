<?php
global $conn;

$id = "";
$tenlop = "";
$khoahoc = "";
$gvcn = "";
$is_edit = false;

// Nếu truyền id qua URL => Chế độ Sửa
if (isset($_GET['id'])) {
    $is_edit = true;

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM LOP WHERE MALOP = '$id'";
    $res = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($res)) {
        $tenlop  = $row['TENLOP'];
        $khoahoc = $row['KHOAHOC'];
        $gvcn    = $row['GVCN'];
    }
}

// Xử lý submit Form
if (isset($_POST['btnLuuLop'])) {
    $malop_input   = trim($_POST['malop']);
    $tenlop_input  = trim($_POST['tenlop']);
    $khoahoc_input = intval($_POST['khoahoc']);
    $gvcn_input    = trim($_POST['gvcn']);

    if ($is_edit) {
        // Cập nhật Lớp
        $sql_save = "UPDATE LOP
                     SET TENLOP='$tenlop_input',
                         KHOAHOC=$khoahoc_input,
                         GVCN='$gvcn_input'
                     WHERE MALOP='$id'";
    } else {
        // Thêm Lớp mới
        $sql_save = "INSERT INTO LOP
                     (MALOP, TENLOP, KHOAHOC, GVCN)
                     VALUES
                     ('$malop_input', '$tenlop_input', $khoahoc_input, '$gvcn_input')";
    }

    if (mysqli_query($conn, $sql_save)) {
        echo "<script>
                alert('Lưu dữ liệu Lớp thành công!');
                window.location.href='index.php?page=lop_list';
              </script>";
    } else {
        $error = mysqli_error($conn);

        echo "<script>
                alert('Lỗi CSDL: " . addslashes($error) . "');
              </script>";
    }
}
?>

<h3>
    <?php echo $is_edit ? "SỬA THÔNG TIN LỚP" : "THÊM LỚP HỌC MỚI"; ?>
</h3>

<form method="POST" action="">
    <table class="db-form-table">

        <tr>
            <td>Mã Lớp:</td>
            <td>
                <input
                    type="text"
                    name="malop"
                    value="<?php echo $is_edit ? htmlspecialchars($id) : ''; ?>"
                    <?php echo $is_edit ? 'readonly' : ''; ?>
                    required
                >
            </td>
        </tr>

        <tr>
            <td>Tên Lớp:</td>
            <td>
                <input
                    type="text"
                    name="tenlop"
                    value="<?php echo htmlspecialchars($tenlop); ?>"
                    required
                >
            </td>
        </tr>

        <tr>
            <td>Khóa Học:</td>
            <td>
                <input
                    type="number"
                    name="khoahoc"
                    value="<?php echo htmlspecialchars($khoahoc); ?>"
                    required
                >
            </td>
        </tr>

        <tr>
            <td>GVCN:</td>
            <td>
                <input
                    type="text"
                    name="gvcn"
                    value="<?php echo htmlspecialchars($gvcn); ?>"
                    required
                >
            </td>
        </tr>

        <tr>
            <td></td>
            <td class="form-buttons">
                <input type="submit" name="btnLuuLop" value="Lưu Dữ Liệu">

                <a href="index.php?page=lop_list">
                    <input type="button" value="Hủy">
                </a>
            </td>
        </tr>

    </table>
</form>