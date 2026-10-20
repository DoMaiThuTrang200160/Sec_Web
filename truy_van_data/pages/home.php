<?php
global $conn;
// Câu truy vấn lấy danh sách lớp
$query = "SELECT * FROM LOP";
// --- CÁCH 1: Sử dụng mysqli_fetch_row() ---
echo "<b>Danh sách các lớp (cách 1):</b><br>";
$result1 = mysqli_query($conn, $query);
if ($result1) {
    while ($row = mysqli_fetch_row($result1)) {
        $maLop = $row[0];
        $tenLop = $row[1];
        echo "<a href='index.php?page=listStudentInClass&classID=" . urlencode($maLop) . "'>" . htmlspecialchars($maLop) . "</a><br>";
    }
}
// --- CÁCH 2: Sử dụng mysqli_fetch_array() ---
echo "<br><b>Danh sách các lớp (cách 2):</b><br>";
$result2 = mysqli_query($conn, $query);
if ($result2) {
    while ($row = mysqli_fetch_array($result2)) {
        $maLop = $row[0];
        $tenLop = $row[1];
        echo "<a href='index.php?page=listStudentInClass&classID=" . urlencode($maLop) . "'>" . htmlspecialchars($maLop) . "</a><br>";
    }
}
// --- CÁCH 3: Sử dụng mysqli_fetch_assoc() ---
echo "<br><b>Danh sách các lớp (cách 3):</b><br>";
$result3 = mysqli_query($conn, $query);
if ($result3) {
    while ($row = mysqli_fetch_assoc($result3)) {
        $maLop = $row["MALOP"];
        $tenLop = $row["TENLOP"];
        echo "<a href='index.php?page=listStudentInClass&classID=" . urlencode($maLop) . "'>" . htmlspecialchars($maLop) . "</a><br>";
    }
}
?>