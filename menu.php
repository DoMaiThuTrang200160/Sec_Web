<div class="sidebar">
	<ul class="category-list">
		<p><strong>2. Bài tập HTML và CSS</strong></p>
		<li class="category-item">
			<a href="bai_2_3/trang_gioi_thieu.html" target="content-area">2.7.2. Trang giới thiệu</a>
		</li>
		<li class="category-item">
			<a href="bai_2_3/bang_diem.html" target="content-area">2.7.3. Bảng điểm cá nhân</a>
		</li>
		<li class="category-item">
			<a href="bai_2_3/CV.html" target="content-area">2.7.4. CV cá nhân</a>
		</li>
		<li class="category-item">
			<a href="bai_2_3/trang_tin.html" target="content-area">2.7.5. Trang thông tin</a>
		</li>
		<p><strong>3. Bài tập HTML, CSS và JavsScript</strong></p>
		<li class="category-item">
			<a href="bai_2_3/trac_nghiem.html" target="content-area">3.7.2. Trắc nghiệm</a>
		</li>
		<li class="category-item">
			<a href="bai_2_3/nhap_lieu_lop.html" target="content-area">3.7.3. Form nhập table LOP</a>
		</li>
		<li class="category-item">
			<a href="bai_2_3/nhap_lieu_ho_so.html" target="content-area">3.7.4. Form nhập table HOSO</a>
		</li>
		<li class="category-item">
			<a href="bai_2_3/dang_ky_tv.html" target="content-area">3.7.5. Đăng ký thành viên</a>
		</li>
		<li class="category-item">
			<a href="bai_2_3/ds_nhan_su.html" target="content-area">3.7.6. Danh sách nhân sự</a>
		</li>
		<li class="category-item">
			<a href="bai_2_3/thuc_don.html" target="content-area">3.7.7. Thực đơn</a>
		</li>
		<li class="category-item">
			<a href="bai_2_3/tab_hien_thi.html" target="content-area">3.7.8. Tab</a>
		</li>
		<li class="category-item">
			<a href="bai_2_3/cay_hien_thi.html" target="content-area">3.7.9. Cây</a>
		</li>
		<li class="category-item">
			<a href="bai_2_3/may_tinh.html" target="content-area">3.7.10. Máy tính</a>
		</li>
		<li class="category-item">
			<a href="bai_2_3/hoat_canh.html" target="content-area">3.7.11. Hoạt cảnh</a>
		</li>
		<li class="category-item">
			<a href="bai_2_3/sap_xep_tim_kiem.html" target="content-area">3.7.12. Sắp xếp và tìm kiếm</a>
		</li>
		<p><strong>4. Bài tập PHP và CSDL</strong></p>
		<li class="category-item">
			<a href="dung_template/index.php" target="content-area">4.7.2. Sử dụng template</a>
		</li>
		<li class="category-item">
			<a href="lay_gui_data/index.php" target="content-area">4.7.3. Lấy và gửi dữ liệu</a>
		</li>
		<li class="category-item">
			<a href="getform/index.php" target="content-area">4.7.4. GetForm</a>
		</li>
		<li class="category-item">
			<a href="session/index.php" target="content-area">4.7.5. Phiên</a>
		</li>
		<li class="category-item">
			<a href="cookie/index.php" target="content-area">4.7.6. Cookie</a>
		</li>
		<li class="category-item">
			<a href="function/index.php" target="content-area">4.7.7. Function</a>
		</li>
		<li class="category-item">
			<a href="doc_ghi_file/index.php" target="content-area">4.7.8. Đọc, ghi file</a>
		</li>
		<li class="category-item">
			<a href="thao_tac_file_data_flow/index.php" target="content-area">4.7.9. Thao tác file và data flow</a>
		</li>
		<li class="category-item">
			<a href="web_da_ngon_ngu/index.php" target="content-area">4.7.10. Website đa ngôn ngữ</a>
		</li>
		<li class="category-item">
			<a href="ket_noi_truy_van_csdl/index.php" target="content-area">4.7.11. Kết nối và truy vấn CSDL cơ bản</a>
		</li>
		<li class="category-item">
			<a href="truy_van_data/index.php" target="content-area">4.7.12. Truy vấn dữ liệu</a>
		</li>
		<li class="category-item">
			<a href="web_end_user/index.php" target="content-area">4.7.13-16. Web bán laptop</a>
		</li>
	</ul>
	<script>
		const menuLinks = document.querySelectorAll('.category-item a');
		menuLinks.forEach(function (link) {
			link.addEventListener('click', function () {
				menuLinks.forEach(function (item) {
					item.classList.remove('selected');
				});
				this.classList.add('selected');
			});
		});
	</script>
</div>