<?php
global $conn;
if (isset($_GET['id'])) {
    $id_del = mysqli_real_escape_string($conn, $_GET['id']);
    $sql_del = "DELETE FROM HOSO WHERE MAHS = '$id_del'";
    if (mysqli_query($conn, $sql_del)) {
        echo "<script>
                alert('Xóa học sinh thành công!');
                window.location.href='index.php?page=hoso_list';
              </script>";
    } else {
        echo "<script>
                alert('Lỗi CSDL: Không thể xóa!');
                window.location.href='index.php?page=hoso_list';
              </script>";
    }
} else {
    header("Location: index.php?page=hoso_list");
    exit();
}
?>