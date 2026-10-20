<?php

/**
 * Chuẩn hóa nội dung để phục vụ việc tìm từ khóa.
 */
function normalizeProductText($text)
{
    $text = mb_strtolower((string)$text, 'UTF-8');

    // Chuẩn hóa một số ký hiệu thường gặp
    $text = str_replace(
        ['-', '_', '/', ',', '.', '(', ')'],
        ' ',
        $text
    );

    // Loại bỏ khoảng trắng thừa
    $text = preg_replace('/\s+/', ' ', $text);

    return trim($text);
}


/**
 * Gộp 3 nguồn thông tin của sản phẩm:
 * 1. Tên sản phẩm
 * 2. Thông số
 * 3. Mô tả
 */
function buildProductText($name, $specs = '', $description = '')
{
    return normalizeProductText(
        $name . ' ' .
        $specs . ' ' .
        $description
    );
}


/**
 * Tìm ID thương hiệu dựa trên:
 * - Tên sản phẩm
 * - Thông số
 * - Mô tả
 *
 * @param mysqli $conn
 * @param string $name
 * @param string $specs
 * @param string $description
 * @return int
 */
function getBrandId($conn, $name, $specs = '', $description = '')
{
    $text = buildProductText(
        $name,
        $specs,
        $description
    );

    /*
     * Các từ khóa dùng để nhận diện thương hiệu.
     *
     * Mỗi thương hiệu có nhiều cách xuất hiện
     * trong tên sản phẩm.
     */
    $brandRules = [
        'Dell' => [
            'dell',
            'inspiron',
            'xps',
            'latitude',
            'precision',
            'vostro',
            'alienware'
        ],

        'ASUS' => [
            'asus',
            'vivobook',
            'zenbook',
            'expertbook',
            'rog',
            'tuf'
        ],

        'Acer' => [
            'acer',
            'aspire',
            'swift',
            'nitro',
            'predator',
            'chromebook'
        ],

        'HP' => [
            'hp',
            'envy',
            'pavilion',
            'probook',
            'elitebook',
            'omen',
            'victus'
        ],

        'Lenovo' => [
            'lenovo',
            'thinkpad',
            'ideapad',
            'yoga',
            'legion',
            'loq'
        ],

        'MSI' => [
            'msi',
            'modern',
            'prestige',
            'summit',
            'raider',
            'stealth'
        ],

        'LG' => [
            'lg',
            'gram'
        ],

        'Apple' => [
            'apple',
            'macbook',
            'mac book',
            'macbook air',
            'macbook pro'
        ]
    ];


    /*
     * Kiểm tra từng thương hiệu.
     */
    foreach ($brandRules as $brandName => $keywords) {

        foreach ($keywords as $keyword) {

            if (mb_strpos(
                $text,
                normalizeProductText($keyword),
                0,
                'UTF-8'
            ) !== false) {

                /*
                 * Tìm ID brand trong DB.
                 */
                $stmt = $conn->prepare(
                    "SELECT id
                     FROM brand
                     WHERE name = ?
                     LIMIT 1"
                );

                $stmt->bind_param(
                    "s",
                    $brandName
                );

                $stmt->execute();

                $result = $stmt->get_result();
                $brand = $result->fetch_assoc();

                $stmt->close();

                if ($brand) {
                    return (int)$brand['id'];
                }
            }
        }
    }


    /*
     * Không xác định được thương hiệu.
     *
     * Không tự ý gán bừa.
     * Trả về 0 để code thêm sản phẩm
     * có thể báo lỗi cho người dùng.
     */
    return 0;
}


/**
 * Xác định danh mục theo nhu cầu sử dụng.
 *
 * Các category:
 * 1 = Gaming
 * 2 = Đồ họa
 * 3 = Văn phòng
 * 4 = Học tập
 *
 * Hàm sử dụng đồng thời:
 * - Tên sản phẩm
 * - Thông số
 * - Mô tả
 */
function getCategoryId($conn, $name, $specs = '', $description = '')
{
    $text = buildProductText(
        $name,
        $specs,
        $description
    );


    /*
     * -------------------------------------------------
     * 1. GAMING
     * -------------------------------------------------
     *
     * Gaming được kiểm tra trước vì một sản phẩm
     * của ASUS / Acer / Lenovo / MSI...
     * hoàn toàn có thể là laptop gaming.
     */
    $gamingKeywords = [
        'gaming',
        'gamer',
        'nitro',
        'predator',
        'rog',
        'tuf gaming',
        'legion',
        'loq',
        'omen',
        'victus',
        'alienware',
        'raider',
        'stealth',
        'rtx',
        'game',
        'chơi game',
        'choi game'
    ];


    foreach ($gamingKeywords as $keyword) {

        if (mb_strpos(
            $text,
            normalizeProductText($keyword),
            0,
            'UTF-8'
        ) !== false) {

            return findCategoryId(
                $conn,
                'Gaming'
            );
        }
    }


    /*
     * -------------------------------------------------
     * 2. ĐỒ HỌA
     * -------------------------------------------------
     */
    $graphicKeywords = [
        'proart',
        'studiobook',
        'studio',
        'creator',
        'workstation',
        'render',
        'rendering',
        'đồ họa',
        'do hoa',
        'thiết kế',
        'thiet ke',
        'dựng phim',
        'dung phim',
        'video editing',
        'chỉnh sửa video',
        'chinh sua video',
        'photoshop',
        'premiere',
        'after effects',
        '3d',
        'cad',
        'blender'
    ];


    foreach ($graphicKeywords as $keyword) {

        if (mb_strpos(
            $text,
            normalizeProductText($keyword),
            0,
            'UTF-8'
        ) !== false) {

            return findCategoryId(
                $conn,
                'Đồ họa'
            );
        }
    }


    /*
     * -------------------------------------------------
     * 3. VĂN PHÒNG
     * -------------------------------------------------
     */
    $officeKeywords = [
        'văn phòng',
        'van phong',
        'office',
        'business',
        'doanh nghiệp',
        'doanh nghiep',
        'work',
        'công việc',
        'cong viec',
        'business laptop',
        'enterprise',
        'excel',
        'word',
        'powerpoint'
    ];


    foreach ($officeKeywords as $keyword) {

        if (mb_strpos(
            $text,
            normalizeProductText($keyword),
            0,
            'UTF-8'
        ) !== false) {

            return findCategoryId(
                $conn,
                'Văn phòng'
            );
        }
    }


    /*
     * -------------------------------------------------
     * 4. HỌC TẬP
     * -------------------------------------------------
     */
    $studyKeywords = [
        'học tập',
        'hoc tap',
        'sinh viên',
        'sinh vien',
        'student',
        'students',
        'học sinh',
        'hoc sinh',
        'education',
        'chromebook',
        'online learning',
        'học online',
        'hoc online'
    ];


    foreach ($studyKeywords as $keyword) {

        if (mb_strpos(
            $text,
            normalizeProductText($keyword),
            0,
            'UTF-8'
        ) !== false) {

            return findCategoryId(
                $conn,
                'Học tập'
            );
        }
    }


    /*
     * -------------------------------------------------
     * 5. PHÂN LOẠI DỰ PHÒNG
     * -------------------------------------------------
     *
     * Nếu không có keyword rõ ràng:
     * mặc định là Văn phòng.
     *
     * Đây là fallback, không phải rule chính.
     */
    return findCategoryId(
        $conn,
        'Văn phòng'
    );
}


/**
 * Lấy ID category từ tên category.
 */
function findCategoryId($conn, $categoryName)
{
    $stmt = $conn->prepare(
        "SELECT id
         FROM category
         WHERE name = ?
         LIMIT 1"
    );

    $stmt->bind_param(
        "s",
        $categoryName
    );

    $stmt->execute();

    $result = $stmt->get_result();
    $category = $result->fetch_assoc();

    $stmt->close();

    return $category
        ? (int)$category['id']
        : 0;
}