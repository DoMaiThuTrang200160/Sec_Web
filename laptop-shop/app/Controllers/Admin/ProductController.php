<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Core\Logger;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // Whitelist MIME thật (không tin đuôi file .jpg/.png do client tự đặt tên)
    private array $allowedMimes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    private int $maxSize = 3 * 1024 * 1024; // 3MB

    public function index(): void
    {
        $this->render('admin/products/list', ['products' => Product::all()], 'admin');
    }

    public function addForm(): void
    {
        $this->render('admin/products/add', ['categories' => Category::all('name ASC')], 'admin');
    }

    public function add(): void
    {
        $data = Request::all();
        $v = new Validator($data);
        $v->required('name', 'Tên sản phẩm')->required('category_id', 'Danh mục')
          ->required('price', 'Giá')->numeric('price', 'Giá')->required('brand', 'Thương hiệu');

        if ($v->fails()) {
            $this->render('admin/products/add', [
                'errors' => $v->errors(), 'old' => $data, 'categories' => Category::all('name ASC'),
            ], 'admin');
            return;
        }

        [$imageName, $uploadError] = $this->handleUpload(Request::file('image'));
        if ($uploadError) {
            $this->render('admin/products/add', [
                'errors' => ['image' => $uploadError], 'old' => $data, 'categories' => Category::all('name ASC'),
            ], 'admin');
            return;
        }

        Product::create([
            'category_id'    => (int) $data['category_id'],
            'name'           => $data['name'],
            'slug'           => $this->slugify($data['name']),
            'price'          => (float) $data['price'],
            'discount_price' => $data['discount_price'] ?: null,
            // Lọc nội dung CKEditor trước khi lưu DB - chống Stored XSS
            'description'    => Validator::sanitizeRichText($data['description'] ?? ''),
            'image'          => $imageName ?? '',
            'brand'          => $data['brand'],
        ]);

        Session::flash('success', 'Thêm sản phẩm thành công.');
        $this->redirect('/admin/products');
    }

    public function editForm($id): void
    {
        $product = Product::find((int) $id);
        if (!$product) { $this->redirect('/admin/products'); }
        $this->render('admin/products/edit', ['product' => $product, 'categories' => Category::all('name ASC')], 'admin');
    }

    public function edit($id): void
    {
        $data = Request::all();
        $product = Product::find((int) $id);
        if (!$product) { $this->redirect('/admin/products'); }

        $v = new Validator($data);
        $v->required('name', 'Tên sản phẩm')->required('category_id', 'Danh mục')
          ->required('price', 'Giá')->numeric('price', 'Giá');

        if ($v->fails()) {
            $this->render('admin/products/edit', [
                'product' => array_merge($product, $data), 'errors' => $v->errors(), 'categories' => Category::all('name ASC'),
            ], 'admin');
            return;
        }

        $imageName = $product['image'];
        if (!empty($_FILES['image']['name'])) {
            [$newImage, $uploadError] = $this->handleUpload(Request::file('image'));
            if ($uploadError) {
                $this->render('admin/products/edit', [
                    'product' => $product, 'errors' => ['image' => $uploadError], 'categories' => Category::all('name ASC'),
                ], 'admin');
                return;
            }
            $imageName = $newImage;
        }

        Product::update((int) $id, [
            'category_id'    => (int) $data['category_id'],
            'name'           => $data['name'],
            'slug'           => $this->slugify($data['name']),
            'price'          => (float) $data['price'],
            'discount_price' => $data['discount_price'] ?: null,
            'description'    => Validator::sanitizeRichText($data['description'] ?? ''),
            'image'          => $imageName,
            'brand'          => $data['brand'],
        ]);

        Session::flash('success', 'Cập nhật sản phẩm thành công.');
        $this->redirect('/admin/products');
    }

    public function detail($id): void
    {
        $product = Product::find((int) $id);
        if (!$product) { $this->redirect('/admin/products'); }
        $this->render('admin/products/detail', ['product' => $product], 'admin');
    }

    public function delete($id): void
    {
        Product::delete((int) $id);
        Session::flash('success', 'Đã xoá sản phẩm.');
        $this->redirect('/admin/products');
    }

    // Validate + lưu file upload an toàn:
    // - Check MIME THẬT bằng finfo (không tin đuôi file .jpg client tự đặt - có thể là shell.php giả dạng)
    // - Giới hạn kích thước
    // - Đổi tên file thành random hex, KHÔNG dùng tên gốc từ người dùng (tránh path traversal / đoán đường dẫn / ghi đè)
    private function handleUpload(?array $file): array
    {
        if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return [null, null];
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return [null, 'Lỗi khi upload file.'];
        }
        if ($file['size'] > $this->maxSize) {
            return [null, 'File ảnh vượt quá 3MB.'];
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!isset($this->allowedMimes[$mime])) {
            Logger::log('security', "Upload bị chặn - MIME không hợp lệ ($mime) - IP: " . ($_SERVER['REMOTE_ADDR'] ?? '?'));
            return [null, 'Chỉ chấp nhận file ảnh JPG, PNG hoặc WEBP.'];
        }

        $ext = $this->allowedMimes[$mime];
        $newName = bin2hex(random_bytes(16)) . '.' . $ext;
        $destination = __DIR__ . '/../../../public/uploads/products/' . $newName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return [null, 'Không thể lưu file ảnh.'];
        }
        return [$newName, null];
    }

    private function slugify(string $text): string
    {
        $text = preg_replace('/[^a-zA-Z0-9]+/', '-', $text);
        return strtolower(trim($text, '-')) . '-' . substr(md5(uniqid()), 0, 5);
    }
}
