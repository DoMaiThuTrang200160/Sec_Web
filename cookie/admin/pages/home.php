<?php
// Xử lý thêm Link mới vào Cookie
if (isset($_POST['btnAddLink'])) {
    $title = trim($_POST['txtTitle']);
    $url = trim($_POST['txtURL']);
    if (!empty($title) && !empty($url)) {
        // Lấy danh sách link hiện tại từ Cookie
        $links = isset($_COOKIE['FavLinks']) ? json_decode($_COOKIE['FavLinks'], true) : array();
        // Thêm link mới
        $links[] = array('title' => $title, 'url' => $url);
        // Cập nhật Cookie trong 30 ngày
        setcookie('FavLinks', json_encode($links), time() + 30 * 24 * 60 * 60, "/");
        // Reload để nhận Cookie mới
        header("Location: index.php?page=home");
        exit();
    }
}
// Đọc danh sách link từ Cookie
$fav_links = isset($_COOKIE['FavLinks']) ? json_decode($_COOKIE['FavLinks'], true) : array();
$last_login = isset($_COOKIE['LastLogin']) ? $_COOKIE['LastLogin'] : 'Lần đầu đăng nhập';
?>
<div class="admin-home">
    <h3>TRANG QUẢN TRỊ ADMINISTRATOR</h3>
    <div class="admin-welcome">
        <p>Xin chào <strong><?php echo htmlspecialchars($_SESSION['Username']); ?></strong>!</p>
        <p>Lần đăng nhập gần nhất lưu từ Cookie: <strong><?php echo htmlspecialchars($last_login); ?></strong></p>
    </div>
    <h4>Danh sách Web Link ưa thích</h4>
    <?php if (!empty($fav_links)): ?>
        <div class="favorite-list">
            <?php foreach ($fav_links as $item): ?>
                <?php
                $item_url = htmlspecialchars($item['url']);
                $item_title = htmlspecialchars($item['title']);
                ?>
                <div class="favorite-item">
                    <a href="<?php echo $item_url; ?>" target="_blank"><?php echo $item_title; ?></a>
                    <span>(<?php echo $item_url; ?>)</span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="no-data">Chưa có Web Link nào trong danh sách ưa thích.</p>
    <?php endif; ?>
    <h4>Thêm Web Link ưa thích mới</h4>
    <form action="" method="POST" class="link-form">
        <div class="form-group">
            <label for="txtTitle">Tên trang web</label>
            <input type="text" id="txtTitle" name="txtTitle" placeholder="Ví dụ: Google" required>
        </div>
        <div class="form-group">
            <label for="txtURL">Đường dẫn (URL)</label>
            <input type="url" id="txtURL" name="txtURL" placeholder="https://google.com" required>
        </div>
        <button type="submit" name="btnAddLink">Thêm vào Cookie</button>
    </form>
</div>