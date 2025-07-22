<?php

/**
 * Summary of upload
 * @param mixed $file $_FILES cần upload
 * @param string $uploadDir Thư mục lưu file
 * @param string|null $uploadFileName Tên tập tin sau khi upload (nếu không cung cấp sẽ tự tạo)
 * @return void
 */
function upload($file, $uploadDir, $uploadFileName = null): string
{
  $filename = $uploadFileName;
  if (!$filename) {
    $fileBaseName = pathinfo($filename, PATHINFO_FILENAME);
    $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
    $filename = $fileBaseName . '-' . time() . '.' . $fileExtension;
  }

  $uploadPath = 'uploads/' . trim($uploadDir, '/') . '/' . $filename;
  if (!is_dir(dirname($uploadPath))) {
    mkdir(dirname($uploadPath), 0755, true);
  }
  move_uploaded_file($file['tmp_name'], $uploadPath);
  return $uploadPath;
}