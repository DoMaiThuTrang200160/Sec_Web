<?php
$filePath = "data/student.txt";
$students = array();
if (file_exists($filePath)) {
    // Đọc tất cả các dòng trong file vào mảng
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    // Cứ 3 dòng gom thành 1 sinh viên
    $count = count($lines);
    for ($i = 0; $i < $count; $i += 3) {
        if (isset($lines[$i])) {
            $students[] = array(
                'ten' => trim($lines[$i]),
                'diachi' => isset($lines[$i + 1]) ? trim($lines[$i + 1]) : '',
                'tuoi' => isset($lines[$i + 2]) ? trim($lines[$i + 2]) : ''
            );
        }
    }
}
?>
<div class="student-page">
    <h3>DANH SÁCH SINH VIÊN</h3>
    <div class="student-table-wrapper">
        <table class="student-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Địa chỉ</th>
                    <th>Tuổi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($students)): ?>
                    <?php foreach ($students as $index => $sv): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($sv['ten']); ?></td>
                            <td><?php echo htmlspecialchars($sv['diachi']); ?></td>
                            <td><?php echo htmlspecialchars($sv['tuoi']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="no-data">Chưa có dữ liệu sinh viên!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>