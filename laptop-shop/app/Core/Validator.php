<?php
namespace App\Core;

// Xử lí hợp thức hoá dữ liệu tập trung - mọi Controller dùng chung 1 bộ rule thay vì
// viết if/else validate rải rác từng nơi.
class Validator
{
    private array $errors = [];

    public function __construct(private array $data) {}

    public function required(string $field, string $label): self
    {
        if (empty($this->data[$field] ?? null)) {
            $this->errors[$field] = "$label không được để trống.";
        }
        return $this;
    }

    public function email(string $field): self
    {
        if (!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = 'Email không hợp lệ.';
        }
        return $this;
    }

    public function numeric(string $field, string $label): self
    {
        if (!empty($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->errors[$field] = "$label phải là số.";
        }
        return $this;
    }

    public function min(string $field, int $length, string $label): self
    {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->errors[$field] = "$label phải có ít nhất $length ký tự.";
        }
        return $this;
    }

    public function fails(): bool { return !empty($this->errors); }
    public function errors(): array { return $this->errors; }

    // Lọc nội dung rich text (CKEditor) trước khi lưu DB - chống Stored XSS.
    // Lưu ý: strip_tags chỉ loại bỏ THẺ không nằm trong whitelist, nó KHÔNG loại bỏ
    // thuộc tính nguy hiểm trong thẻ được phép (vd <img src=x onerror=...>), nên phải
    // tự loại thêm on*="..." và href/src="javascript:...". Đây là giải pháp đủ dùng cho
    // bài tập; ở production nên dùng thư viện chuyên dụng như HTMLPurifier.
    public static function sanitizeRichText(string $html): string
    {
        $allowedTags = '<p><br><b><strong><i><em><u><ul><ol><li><h1><h2><h3><h4><a><img><span><div><blockquote>';
        $html = strip_tags($html, $allowedTags);
        // Lọc thuộc tính on*=... ở cả 3 dạng: "...", '...', và KHÔNG có ngoặc (vd onerror=alert(1))
        $html = preg_replace('/\son\w+\s*=\s*"[^"]*"/i', '', $html);
        $html = preg_replace("/\son\w+\s*=\s*'[^']*'/i", '', $html);
        $html = preg_replace('/\son\w+\s*=\s*[^\s"\'>]+/i', '', $html);
        $html = preg_replace('/(href|src)\s*=\s*["\']?\s*javascript:[^"\'>\s]*["\']?/i', '$1="#"', $html);
        return $html;
    }
}
