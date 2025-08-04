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

  $uploadPath = 'uploads/' . ($uploadDir ? (trim($uploadDir, '/') . '/') : '');

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
    mkdir($uploadPath, 0777, true);
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

/**
 * Upload nhiều file vào thư mục chỉ định
 *
 * @param array $files Mảng $_FILES chứa thông tin các file upload (mặc định là $_FILES['images'])
 * @param string $uploadDir Thư mục con trong 'uploads/' để lưu file
 * @return array Mảng các đường dẫn đầy đủ của các file upload thành công
 */
function uploadMultipleFiles(array $files = null, string $uploadDir): array
{
  // Sử dụng $_FILES['images'] nếu không truyền $files
  $files = $files ?? $_FILES['images'] ?? [];

  // Kiểm tra xem có file nào được gửi hay không
  if (!isset($files['name']) || empty($files['name'][0])) {
    throw new InvalidArgumentException('Không có file nào được đính kèm.');
  }

  $uploadPath = 'uploads/' . ($uploadDir ? (trim($uploadDir, '/') . '/') : '');
  $uploadedFiles = [];

  // Tạo thư mục nếu chưa tồn tại
  if (!is_dir($uploadPath) && !mkdir($uploadPath, 0755, true)) {
    throw new InvalidArgumentException('Không thể tạo thư mục lưu trữ: ' . $uploadPath);
  }

  // Xử lý từng file
  foreach ($files['name'] as $index => $name) {
    // Kiểm tra lỗi upload
    if ($files['error'][$index] !== UPLOAD_ERR_OK) {
      continue; // Bỏ qua file lỗi
    }

    // Tạo tên file duy nhất
    $fileBaseName = pathinfo($name, PATHINFO_FILENAME);
    $fileBaseName = preg_replace('/[^a-zA-Z0-9_-]/', '', $fileBaseName); // Làm sạch tên file
    $fileExtension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    $filename = $fileBaseName . '-' . time() . '-' . uniqid() . '.' . $fileExtension;
    $fullPath = $uploadPath . $filename;

    // Kiểm tra và di chuyển file
    if (!is_uploaded_file($files['tmp_name'][$index])) {
      continue;
    }

    if (move_uploaded_file($files['tmp_name'][$index], $fullPath)) {
      $uploadedFiles[] = $fullPath;
    }
  }

  // Kiểm tra xem có file nào được upload thành công không
  if (empty($uploadedFiles)) {
    throw new InvalidArgumentException('Không có file nào được upload thành công.');
  }

  return $uploadedFiles;
}