<div class="calculate-page">
<!-- Chữ chuyển động -->
<div class="animation-box">
    <img id="text-animation" src="../../../image/chu_0.jpg" alt="Chữ xin chào">
</div>
<h3>Trang tính toán</h3>
<form method="post" class="calculate-form">
    <div class="form-group">
        <label for="n">Nhập số n:</label>
        <input type="number" id="n" name="n" min="0" required>
    </div>
    <div class="form-group">
        <label for="r">Nhập bán kính r:</label>
        <input type="number" id="r" name="r" min="0" step="any" required>
    </div>
    <button type="submit" name="calculate">Tính toán</button>
</form>
<h3>Kết quả</h3>
<?php
if (isset($_POST['calculate'])) {
    $n = $_POST['n'];
    $giai_thua = 1;
    for ($i = 1; $i <= $n; $i++) {
        $giai_thua *= $i;
    }
    echo "<div class='result-box'>";
    echo "<span>Giai thừa của $n</span>";
    echo "<strong>$giai_thua</strong>";
    echo "</div>";
    $r = $_POST['r'];
    $pi = 3.14;
    $dien_tich = $pi * $r * $r;
    $the_tich = (4 / 3) * $pi * pow($r, 3);
    echo "<div class='result-box'>";
    echo "<span>Diện tích hình tròn (r = $r)</span>";
    echo "<strong>$dien_tich</strong>";
    echo "</div>";
    echo "<div class='result-box'>";
    echo "<span>Thể tích khối cầu (r = $r)</span>";
    echo "<strong>" . round($the_tich, 2) . "</strong>";
    echo "</div>";
}
?>
</div>
<style>
    .animation-box {
        width: 100%;
        height: 100px;
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        }
    .animation-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
</style>
<script>
    const frames = [ "../../../image/chu_0.jpg", "../../../image/chu_1.jpg", "../../../image/chu_2.jpg", "../../../image/chu_3.jpg", "../../../image/chu_4.jpg", "../../../image/chu_5.jpg", "../../../image/chu_6.jpg", "../../../image/chu_7.jpg", "../../../image/chu_8.jpg", "../../../image/chu_9.jpg"
    ];
    let currentIndex = 0;
    const textAnimation = document.getElementById("text-animation");
    function nextFrame() {
        currentIndex++;
        if (currentIndex >= frames.length) {
            currentIndex = 0;
        }
        textAnimation.src = frames[currentIndex];
    }
    setInterval(nextFrame, 200);
</script>