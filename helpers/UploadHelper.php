<?php

/**
 * Upload file vào thư mục chỉ định.
 *
 * @param array $file Mảng $_FILES chứa thông tin file upload.
 * @param string $uploadDir Thư mục con trong 'uploads/' để lưu file.
 * @param string|null $uploadFileName Tên file sau khi upload (nếu không cung cấp, tự tạo từ tên file gốc).
 * @return string|null Đường dẫn đầy đủ của file nếu upload thành công, null nếu thất bại.
 */
function upload(array $file, string $uploadDir, ?string $uploadFileName = null): ?string
{
  // Kiểm tra file upload hợp lệ
  if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
    return null;
  }

  $uploadPath = 'uploads/' . trim($uploadDir, '/') . '/';

  // Tạo tên file nếu không được cung cấp
  $filename = $uploadFileName;
  if (!$filename) {
    $fileBaseName = pathinfo($file['name'], PATHINFO_FILENAME);
    $fileBaseName = preg_replace('/[^a-zA-Z0-9_-]/', '', $fileBaseName); // Làm sạch tên file
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = $fileBaseName . '-' . time() . '-' . uniqid() . '.' . $fileExtension;
  }

  // Đường dẫn đầy đủ
  $fullPath = $uploadPath . $filename;

  // Tạo thư mục nếu chưa tồn tại
  if (!is_dir($uploadPath)) {
    mkdir($uploadPath, 0755, true);
  }

  // Kiểm tra và di chuyển file
  if (!is_uploaded_file($file['tmp_name'])) {
    return null;
  }

  if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
    return null;
  }

  return $fullPath;
}