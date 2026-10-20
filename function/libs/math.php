<?php
// Tính tổng các phần tử trong mảng 1 chiều
function tongDay($mangSo) {
    return array_sum($mangSo);
}
// Tìm giá trị nhỏ nhất
function minDay($mangSo) {
    return empty($mangSo) ? 0 : min($mangSo);
}
// Tìm giá trị lớn nhất
function maxDay($mangSo) {
    return empty($mangSo) ? 0 : max($mangSo);
}
// Tính giá trị trung bình cộng
function avgDay($mangSo) {
    if (empty($mangSo)) return 0;
    return array_sum($mangSo) / count($mangSo);
}
// Sắp xếp dãy số tăng dần
function sortDay($mangSo) {
    sort($mangSo);
    return $mangSo;
}
// Đảo ngược dãy số
function daoNguocDay($mangSo) {
    return array_reverse($mangSo);
}
// Tìm max trong ma trận (mảng 2 chiều)
function maxMatran($mang2Chieu) {
    $max = $mang2Chieu[0][0];
    foreach ($mang2Chieu as $row) {
        foreach ($row as $val) {
            if ($val > $max) $max = $val;
        }
    }
    return $max;
}
// Tìm min trong ma trận
function minMatran($mang2Chieu) {
    $min = $mang2Chieu[0][0];
    foreach ($mang2Chieu as $row) {
        foreach ($row as $val) {
            if ($val < $min) $min = $val;
        }
    }
    return $min;
}
// Tính tổng đường chéo chính
function tongTrenCheoChinh($mang2Chieu) {
    $tong = 0;
    $n = count($mang2Chieu);
    for ($i = 0; $i < $n; $i++) {
        $tong += $mang2Chieu[$i][$i];
    }
    return $tong;
}
// Tính tổng đường chéo phụ
function tongTrenCheoPhu($mang2Chieu) {
    $tong = 0;
    $n = count($mang2Chieu);
    for ($i = 0; $i < $n; $i++) {
        $tong += $mang2Chieu[$i][$n - 1 - $i];
    }
    return $tong;
}
// Tính Ma trận Tổng
function tinhMatranTong($matran1, $matran2) {
    $res = [];
    $rows = count($matran1);
    $cols = count($matran1[0]);
    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $cols; $j++) {
            $res[$i][$j] = $matran1[$i][$j] + $matran2[$i][$j];
        }
    }
    return $res;
}
// Tính Ma trận Hiệu
function tinhMatranHieu($matran1, $matran2) {
    $res = [];
    $rows = count($matran1);
    $cols = count($matran1[0]);
    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $cols; $j++) {
            $res[$i][$j] = $matran1[$i][$j] - $matran2[$i][$j];
        }
    }
    return $res;
}
// Tính Ma trận Tích (Nân 2 ma trận n x n)
function tinhMatranTich($matran1, $matran2) {
    $res = [];
    $n = count($matran1);
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n; $j++) {
            $res[$i][$j] = 0;
            for ($k = 0; $k < $n; $k++) {
                $res[$i][$j] += $matran1[$i][$k] * $matran2[$k][$j];
            }
        }
    }
    return $res;
}
// In ma trận ra màn hình dạng dòng/cột
function hienThiMatran($matran) {
    $html = "";
    foreach ($matran as $row) {
        foreach ($row as $val) {
            $html .= $val . "&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        $html .= "<br>";
    }
    return $html;
}
?>