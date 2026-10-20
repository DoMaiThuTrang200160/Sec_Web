<?php
global $conn;
$studentID = isset($_GET['studentID']) ? mysqli_real_escape_string($conn, $_GET['studentID']) : '';
if (!empty($studentID)) {
    $sql = "SELECT HOSO.*, LOP.TENLOP
            FROM HOSO
            LEFT JOIN LOP ON HOSO.LOP = LOP.MALOP
            WHERE HOSO.MAHS = '$studentID'";
    $result = mysqli_query($conn, $sql);
    if ($result && $row = mysqli_fetch_assoc($result)) {
        ?>
        <h3>THÔNG TIN CHI TIẾT HỌC SINH</h3>
        <div class="detail-card">
            <p>
                <b>Mã HS:</b>
                <?php echo htmlspecialchars($row['MAHS']); ?>
            </p>
            <p>
                <b>Họ và tên:</b>
                <?php echo htmlspecialchars($row['HOTEN']); ?>
            </p>
            <p>
                <b>Ngày sinh:</b>
                <?php echo htmlspecialchars($row['NGAYSINH']); ?>
            </p>
            <p>
                <b>Địa chỉ:</b>
                <?php echo htmlspecialchars($row['DIACHI']); ?>
            </p>
            <p>
                <b>Lớp học:</b>
                <?php echo htmlspecialchars($row['TENLOP']); ?>
                (<?php echo htmlspecialchars($row['LOP']); ?>)
            </p>
            <p>
                <b>Điểm Toán:</b>
                <?php echo htmlspecialchars($row['DIEMTOAN']); ?>
            </p>
            <p>
                <b>Điểm Lý:</b>
                <?php echo htmlspecialchars($row['DIEMLY']); ?>
            </p>
            <p>
                <b>Điểm Hóa:</b>
                <?php echo htmlspecialchars($row['DIEMHOA']); ?>
            </p>
            <a
                href="javascript:history.back()"
                class="back-link"
            >
                ← Quay lại
            </a>
        </div>
        <?php
    } else {
        echo "<p class='notice'>Không tìm thấy thông tin học sinh này!</p>";
    }
} else {
    echo "<p class='notice'>Mã học sinh không hợp lệ!</p>";
}
?>