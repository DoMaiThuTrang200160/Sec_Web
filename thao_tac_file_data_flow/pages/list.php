<?php
$filePath = "pages/student.txt";
$students = [];
if (file_exists($filePath)) {
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $totalLines = count($lines);
    $id = 0;
    // Mỗi sinh viên gồm 5 dòng dữ liệu
    for ($i = 0; $i < $totalLines; $i += 5) {
        if (isset($lines[$i])) {
            $students[] = [
                'id'       => $id,
                'ten'      => trim($lines[$i]),
                'ngaysinh' => isset($lines[$i + 1]) ? trim($lines[$i + 1]) : '',
                'diachi'   => isset($lines[$i + 2]) ? trim($lines[$i + 2]) : '',
                'anh'      => isset($lines[$i + 3]) ? trim($lines[$i + 3]) : 'default.png',
                'lop'      => isset($lines[$i + 4]) ? trim($lines[$i + 4]) : ''
            ];
            $id++;
        }
    }
}
?>
<h3>DANH SÁCH SINH VIÊN</h3>
<table class="student-table">
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên</th>
            <th>Ngày sinh</th>
            <th>Địa chỉ</th>
            <th>Ảnh</th>
            <th>Lớp</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($students)): ?>
            <?php foreach ($students as $index => $sv): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($sv['ten']); ?></td>
                    <td><?php echo htmlspecialchars($sv['ngaysinh']); ?></td>
                    <td><?php echo htmlspecialchars($sv['diachi']); ?></td>
                    <td>
                        <img src="uploads/<?php echo htmlspecialchars($sv['anh']); ?>" alt="Avatar" class="avatar-thumb" onerror="this.src='uploads/default.png'">
                    </td>
                    <td><?php echo htmlspecialchars($sv['lop']); ?></td>
                    <td class="action-links">
                        <a href="index.php?page=detail&id=<?php echo $sv['id']; ?>">Detail</a>
                        |
                        <a href="index.php?page=edit&id=<?php echo $sv['id']; ?>">Edit</a>
                        |
                        <a href="index.php?page=delete&id=<?php echo $sv['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa sinh viên này?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="no-data">Danh sách sinh viên trống!</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>