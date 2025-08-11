<?php
/**
 * File test để demo cách sử dụng Rating model
 * Chỉ dùng để test, không dùng trong production
 */

require_once './config.php';
require_once './models/Rating.php';

$ratingModel = new Rating();

// Ví dụ test
$userId = 1;      // ID của user
$productId = 1;   // ID của sản phẩm

echo "=== DEMO KIỂM TRA QUYỀN ĐÁNH GIÁ ===\n\n";

// Test 1: Kiểm tra user có quyền đánh giá không
echo "1. Kiểm tra user {$userId} có quyền đánh giá sản phẩm {$productId}:\n";
$canRate = $ratingModel->canUserRate($userId, $productId);
echo "   Kết quả: " . ($canRate ? "CÓ QUYỀN" : "KHÔNG CÓ QUYỀN") . "\n\n";

// Test 2: Thông tin chi tiết về quyền đánh giá
echo "2. Thông tin chi tiết:\n";
$ratingInfo = $ratingModel->getRatingInfo($userId, $productId);
echo "   - Số lần đã mua: {$ratingInfo['purchase_count']}\n";
echo "   - Số lần đã đánh giá: {$ratingInfo['rating_count']}\n";
echo "   - Còn lại số lần đánh giá: {$ratingInfo['remaining_ratings']}\n";
echo "   - Có thể đánh giá: " . ($ratingInfo['can_rate'] ? "CÓ" : "KHÔNG") . "\n\n";

// Test 3: Lấy thông tin rating của sản phẩm
echo "3. Danh sách đánh giá hiện tại của sản phẩm {$productId}:\n";
$ratings = $ratingModel->getByProductId($productId);
if (empty($ratings)) {
  echo "   Chưa có đánh giá nào.\n";
} else {
  foreach ($ratings as $rating) {
    echo "   - User: {$rating['user_name']} ({$rating['username']})\n";
    echo "     Đánh giá: {$rating['rating']}/5 sao\n";
    echo "     Comment: " . ($rating['comment'] ?: 'Không có') . "\n";
    echo "     Thời gian: {$rating['created_at']}\n\n";
  }
}

// Test 4: Tính điểm trung bình
echo "4. Điểm đánh giá trung bình:\n";
$avgRating = $ratingModel->getAverageRating($productId);
echo "   - Điểm TB: " . round($avgRating['average_rating'], 2) . "/5 sao\n";
echo "   - Tổng số đánh giá: {$avgRating['total_ratings']}\n\n";

echo "=== KẾT THÚC TEST ===\n";
