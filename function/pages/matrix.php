<?php
// Giá trị mặc định 3x3 cho 2 ma trận
$m1_default = [
    [1, 1, 1],
    [2, 2, 2],
    [3, 3, 3]
];
$m2_default = [
    [0, 0, 0],
    [0, 0, 0],
    [0, 0, 0]
];
$m1 = isset($_POST['m1']) ? $_POST['m1'] : $m1_default;
$m2 = isset($_POST['m2']) ? $_POST['m2'] : $m2_default;
$isCalculated = isset($_POST['btnTinh']);
if ($isCalculated) {
    $matranTong = tinhMatranTong($m1, $m2);
    $matranHieu = tinhMatranHieu($m1, $m2);
    $matranTich = tinhMatranTich($m1, $m2);
}
?>
<div class="matrix-page">
    <h3>MATRIX</h3>
    <p class="description">Sử dụng mảng để tính hiệu, tổng, tích 2 ma trận.</p>
    <form action="" method="POST" class="matrix-form">
        <div class="matrix-inputs">
            <div class="matrix-group">
                <h4>Nhập Ma trận 1</h4>
                <table class="matrix-table">
                    <?php for ($i = 0; $i < 3; $i++): ?>
                        <tr>
                            <?php for ($j = 0; $j < 3; $j++): ?>
                                <td>
                                    <input type="number" name="m1[<?php echo $i; ?>][<?php echo $j; ?>]" value="<?php echo $m1[$i][$j]; ?>">
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endfor; ?>
                </table>
            </div>
            <div class="matrix-group">
                <h4>Nhập Ma trận 2</h4>
                <table class="matrix-table">
                    <?php for ($i = 0; $i < 3; $i++): ?>
                        <tr>
                            <?php for ($j = 0; $j < 3; $j++): ?>
                                <td>
                                    <input type="number" name="m2[<?php echo $i; ?>][<?php echo $j; ?>]" value="<?php echo $m2[$i][$j]; ?>">
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endfor; ?>
                </table>
            </div>
        </div>
        <div class="matrix-buttons">
            <input type="button" value="Nhập lại" onclick="window.location.href='index.php?page=matrix'">
            <input type="submit" name="btnTinh" value="Tính">
        </div>
    </form>
    <?php if ($isCalculated): ?>
        <div class="matrix-result">
            <h4>KẾT QUẢ</h4>
            <div class="result-item">
                <strong>Ma trận Tổng:</strong>
                <div class="matrix-output"><?php echo hienThiMatran($matranTong); ?></div>
            </div>
            <div class="result-item">
                <strong>Ma trận Hiệu:</strong>
                <div class="matrix-output"><?php echo hienThiMatran($matranHieu); ?></div>
            </div>
            <div class="result-item">
                <strong>Ma trận Tích:</strong>
                <div class="matrix-output"><?php echo hienThiMatran($matranTich); ?></div>
            </div>
        </div>
    <?php endif; ?>
</div>