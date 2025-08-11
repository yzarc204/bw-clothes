<?php
/**
 * Demo logic rating mới: Mua 1 lần được rate 1 lần, mua 2 lần được rate 2 lần
 */

require_once './config.php';
require_once './models/Rating.php';

$ratingModel = new Rating();

// Demo với các trường hợp khác nhau
$testCases = [
  ['user_id' => 1, 'product_id' => 1, 'description' => 'User 1 - Sản phẩm 1'],
  ['user_id' => 2, 'product_id' => 1, 'description' => 'User 2 - Sản phẩm 1'],
  ['user_id' => 1, 'product_id' => 2, 'description' => 'User 1 - Sản phẩm 2'],
];

echo "=== DEMO LOGIC RATING: MUA NHIỀU LẦN = RATE NHIỀU LẦN ===\n\n";

foreach ($testCases as $testCase) {
  $userId = $testCase['user_id'];
  $productId = $testCase['product_id'];
  $description = $testCase['description'];

  echo "🔍 {$description}\n";
  echo str_repeat("-", 50) . "\n";

  // Lấy thông tin chi tiết
  $ratingInfo = $ratingModel->getRatingInfo($userId, $productId);

  echo "📊 Thống kê:\n";
  echo "   • Số lần đã mua: {$ratingInfo['purchase_count']}\n";
  echo "   • Số lần đã đánh giá: {$ratingInfo['rating_count']}\n";
  echo "   • Còn lại số lần đánh giá: {$ratingInfo['remaining_ratings']}\n";
  echo "   • Có thể đánh giá: " . ($ratingInfo['can_rate'] ? "✅ CÓ" : "❌ KHÔNG") . "\n";

  // Demo tạo đánh giá
  if ($ratingInfo['can_rate']) {
    echo "\n💬 Thử tạo đánh giá...\n";
    $success = $ratingModel->create($userId, $productId, 5, "Sản phẩm rất tốt! (Đánh giá lần " . ($ratingInfo['rating_count'] + 1) . ")");

    if ($success) {
      echo "   ✅ Đánh giá thành công!\n";

      // Cập nhật thông tin sau khi đánh giá
      $newRatingInfo = $ratingModel->getRatingInfo($userId, $productId);
      echo "   📈 Sau khi đánh giá:\n";
      echo "      • Số lần đã đánh giá: {$newRatingInfo['rating_count']}\n";
      echo "      • Còn lại số lần đánh giá: {$newRatingInfo['remaining_ratings']}\n";
    } else {
      echo "   ❌ Đánh giá thất bại!\n";
    }
  } else {
    echo "\n⚠️  Không thể đánh giá vì:\n";
    if ($ratingInfo['purchase_count'] == 0) {
      echo "   • Chưa mua sản phẩm này\n";
    } else {
      echo "   • Đã đánh giá hết số lần cho phép ({$ratingInfo['purchase_count']} lần)\n";
    }
  }

  echo "\n" . str_repeat("=", 60) . "\n\n";
}

// Demo hiển thị tất cả đánh giá của sản phẩm 1
echo "📋 TẤT CẢ ĐÁNH GIÁ CỦA SẢN PHẨM 1:\n";
echo str_repeat("-", 50) . "\n";

$ratings = $ratingModel->getByProductId(1);
if (empty($ratings)) {
  echo "Chưa có đánh giá nào.\n";
} else {
  foreach ($ratings as $rating) {
    echo "👤 {$rating['user_name']} ({$rating['username']})\n";
    echo "   ⭐ {$rating['rating']}/5 sao\n";
    echo "   💬 " . ($rating['comment'] ?: 'Không có comment') . "\n";
    echo "   📅 {$rating['created_at']}\n\n";
  }
}

// Tính điểm trung bình
$avgRating = $ratingModel->getAverageRating(1);
echo "📊 ĐIỂM TRUNG BÌNH SẢN PHẨM 1:\n";
echo "   • Điểm TB: " . round($avgRating['average_rating'], 2) . "/5 sao\n";
echo "   • Tổng số đánh giá: {$avgRating['total_ratings']}\n";

echo "\n=== KẾT THÚC DEMO ===\n";
