<?php
// Huỷ toàn bộ session
session_unset();
session_destroy();
// Quay trở lại trang index.php của End User
header("Location: ../index.php");
exit();
?>