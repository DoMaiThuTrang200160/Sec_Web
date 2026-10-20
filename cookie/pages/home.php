<div class="cookie-page">
    <h3>COOKIE</h3>
    <ul class="cookie-list">
        <li>Cookie là một đoạn dữ liệu được ghi trong máy Client do trình duyệt quản lý. Nó được trình duyệt gửi ngược lên Server mỗi khi Browser tải một trang web từ Server.</li>
        <li>Không dùng Cookie để lưu những thông tin quan trọng vì không đảm bảo an toàn.</li>
        <li>Cookie thường được dùng để ghi nhớ username, password, thời điểm đăng nhập cuối, danh sách nhạc ưa thích,...</li>
    </ul>
    <h3>TẠO COOKIE</h3>
    <ul class="cookie-list">
        <li>
            <code>setcookie("TenCookie", giá trị, [Thời điểm quá hạn tính theo s]);</code><br><i>Ví dụ:</i><br><code>setcookie("TenUser", "Pham Minh", time()+60*60*24*30);</code><br><code>setcookie("lasttime", date('d/m/Y H:i:s'), time()+60*60*24*30);</code>
        </li>
        <li>Nếu không chỉ định thời gian thì Cookie sẽ lưu trong bộ nhớ và sẽ mất khi User đóng Browser.</li>
        <li>Nếu thời điểm quá hạn là một thời điểm trong quá khứ thì Browser sẽ xóa Cookie.</li>
    </ul>
    <h3>SỬ DỤNG COOKIE</h3>
    <p><code>$_COOKIE["Ten"];</code></p>
</div>