<?php
global $conn;

// Cấu hình phân trang
$limit = 10;

$p = isset($_GET['p']) ? intval($_GET['p']) : 1;

if ($p < 1) {
    $p = 1;
}

$start = ($p - 1) * $limit;

// Tính tổng số học sinh
$sql_total = "SELECT COUNT(MAHS) AS total FROM HOSO";

$res_total = mysqli_query($conn, $sql_total);

$row_total = mysqli_fetch_assoc($res_total);

$total_records = $row_total['total'];

$total_pages = ceil($total_records / $limit);

// Lấy danh sách học sinh theo từng trang
$sql = "SELECT HOSO.*, LOP.TENLOP
        FROM HOSO
        LEFT JOIN LOP ON HOSO.LOP = LOP.MALOP
        LIMIT $start, $limit";

$result = mysqli_query($conn, $sql);
?>

<h3>DANH SÁCH HỒ SƠ HỌC SINH</h3>

<div class="page-actions">
    <a href="index.php?page=hoso_form" class="add-link">+ Thêm Học Sinh Mới</a>
</div>

<table class="db-table">
    <thead>
        <tr>
            <th>Mã HS</th>
            <th>Họ Tên</th>
            <th>Ngày Sinh</th>
            <th>Địa Chỉ</th>
            <th>Lớp</th>
            <th>Điểm (Toán / Lý / Hóa)</th>
            <th>Thao Tác</th>
        </tr>
    </thead>

    <tbody>
        <?php if ($result && mysqli_num_rows($result) > 0): ?>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>

                <tr>
                    <td>
                        <?php echo htmlspecialchars($row["MAHS"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["HOTEN"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["NGAYSINH"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["DIACHI"]); ?>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $row["LOP"] . " - " . $row["TENLOP"]
                        );
                        ?>
                    </td>

                    <td class="score-cell">
                        <b><?php echo htmlspecialchars($row["DIEMTOAN"]); ?></b>
                        /
                        <b><?php echo htmlspecialchars($row["DIEMLY"]); ?></b>
                        /
                        <b><?php echo htmlspecialchars($row["DIEMHOA"]); ?></b>
                    </td>

                    <td class="action-links">
                        <a
                            href="index.php?page=hoso_form&id=<?php echo urlencode($row["MAHS"]); ?>"
                            class="action-btn"
                        >
                            Sửa
                        </a>

                        |

                        <a
                            href="index.php?page=hoso_delete&id=<?php echo urlencode($row["MAHS"]); ?>"
                            class="action-btn delete"
                            onclick="return confirm('Bạn có chắc muốn xóa học sinh này?');"
                        >
                            Xóa
                        </a>
                    </td>
                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="7" class="no-data">
                    Chưa có dữ liệu học sinh!
                </td>
            </tr>

        <?php endif; ?>
    </tbody>
</table>

<?php if ($total_pages > 1): ?>

    <div class="pagination">
        <span>Trang:</span>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>

            <a
                href="index.php?page=hoso_list&p=<?php echo $i; ?>"
                class="<?php echo ($i == $p) ? 'active' : ''; ?>"
            >
                <?php echo $i; ?>
            </a>

        <?php endfor; ?>
    </div>

<?php endif; ?>