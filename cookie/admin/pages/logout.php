<?php
// Huỷ các biến Session
session_unset();
session_destroy();
// Quay lại trang index.php phần End user
header("Location: ../index.php");
exit();
?>s