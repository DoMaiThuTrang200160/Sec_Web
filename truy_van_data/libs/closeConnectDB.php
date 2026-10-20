<?php
// 4. Đóng kết nối cơ sở dữ liệu
if (isset($conn) && $conn) {
    mysqli_close($conn);
}
?>