<?php
global $conn;
$classID = isset($_GET['classID']) ? mysqli_real_escape_string($conn, $_GET['classID']) : '';
if (!empty($classID)) {
    // Truy vấn danh sách học sinh thuộc lớp được chọn
    $sql = "SELECT * FROM HOSO WHERE LOP = '$classID'";
    $result = mysqli_query($conn, $sql);
    ?>
    <h3>DANH SÁCH HỌC SINH TRONG LỚP (MÃ LỚP: <?php echo htmlspecialchars($classID); ?>)</h3>
    <table class="student-table">
        <thead>
            <tr>
                <th>Mã HS</th>
                <th>Họ và tên</th>
                <th>Địa chỉ</th>
                <th>Ngày sinh</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['MAHS']); ?></td>
                        <td><?php echo htmlspecialchars($row['HOTEN']); ?></td>
                        <td><?php echo htmlspecialchars($row['DIACHI']); ?></td>
                        <td><?php echo htmlspecialchars($row['NGAYSINH']); ?></td>
                        <td>
                            <a href="index.php?page=studentDetail&studentID=<?php echo urlencode($row['MAHS']); ?>" class="detail-link">Chi tiết</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="no-data">Không có học sinh trong lớp này!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php
} else {
    echo "<p class='notice'>Vui lòng chọn một lớp học để xem danh sách!</p>";
}
?>