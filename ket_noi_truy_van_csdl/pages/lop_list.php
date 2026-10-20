<?php
global $conn;

// Xử lý nút Xóa Lớp
if (isset($_GET['delete_id'])) {
    $id_del = mysqli_real_escape_string($conn, $_GET['delete_id']);

    $sql_del = "DELETE FROM LOP WHERE MALOP = '$id_del'";

    if (mysqli_query($conn, $sql_del)) {
        echo "<script>
                alert('Xóa lớp thành công!');
                window.location.href='index.php?page=lop_list';
              </script>";
    } else {
        echo "<script>
                alert('Lỗi: Không thể xóa lớp này (Có thể do còn học sinh thuộc lớp)!');
                window.location.href='index.php?page=lop_list';
              </script>";
    }
}

$sql = "SELECT * FROM LOP";
$result = mysqli_query($conn, $sql);
?>

<h3>DANH SÁCH LỚP HỌC</h3>

<div class="page-actions">
    <a href="index.php?page=lop_form" class="add-link">+ Thêm Lớp Mới</a>
</div>

<table class="db-table">
    <thead>
        <tr>
            <th>Mã Lớp</th>
            <th>Tên Lớp</th>
            <th>Khóa Học</th>
            <th>GVCN</th>
            <th>Thao Tác</th>
        </tr>
    </thead>

    <tbody>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                $malop   = htmlspecialchars($row["MALOP"]);
                $tenlop  = htmlspecialchars($row["TENLOP"]);
                $khoahoc = htmlspecialchars($row["KHOAHOC"]);
                $gvcn    = htmlspecialchars($row["GVCN"]);
                ?>

                <tr>
                    <td><?php echo $malop; ?></td>
                    <td><?php echo $tenlop; ?></td>
                    <td><?php echo $khoahoc; ?></td>
                    <td><?php echo $gvcn; ?></td>

                    <td class="action-links">
                        <a
                            href="index.php?page=lop_form&id=<?php echo urlencode($malop); ?>"
                            class="action-btn"
                        >
                            Sửa
                        </a>

                        |

                        <a
                            href="index.php?page=lop_list&delete_id=<?php echo urlencode($malop); ?>"
                            class="action-btn delete"
                            onclick="return confirm('Bạn có chắc muốn xóa lớp này?');"
                        >
                            Xóa
                        </a>
                    </td>
                </tr>

                <?php
            }

        } else {
            ?>

            <tr>
                <td colspan="5" class="no-data">
                    Chưa có dữ liệu lớp học!
                </td>
            </tr>

            <?php
        }
        ?>
    </tbody>
</table>