<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : -1;
$filePath = "pages/student.txt";
if (file_exists($filePath) && $id >= 0) {
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $startIndex = $id * 5;
    if (isset($lines[$startIndex])) {
        // Xóa 5 dòng của sinh viên được chọn
        array_splice($lines, $startIndex, 5);
        // Ghi đè lại file
        file_put_contents($filePath, implode("\n", $lines) . (count($lines) > 0 ? "\n" : ""));
    }
}
header("Location: index.php?page=list");
exit();
?>