<?php
require_once './models/BaseModel.php';

class Category extends BaseModel
{
  /**
   * Tạo mới một danh mục.
   *
   * @param string $name Tên danh mục.
   * @return int ID của danh mục mới tạo.
   */
  public function create($name)
  {
    $sql = "INSERT INTO categories (name) VALUES (:name)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      'name' => $name
    ]);
    return $this->db->lastInsertId();
  }

  /**
   * Cập nhật tên danh mục theo ID.
   *
   * @param int $id ID danh mục.
   * @param string $name Tên mới.
   */
  public function update($id, $name)
  {
    $sql = "UPDATE categories SET name = :name WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      'name' => $name,
      'id' => $id
    ]);
  }

  /**
   * Xóa danh mục theo ID.
   *
   * @param int $id ID danh mục.
   */
  public function delete($id)
  {
    $sql = "DELETE FROM categories WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      'id' => $id
    ]);
  }

  /**
   * Lấy tất cả danh mục.
   *
   * @return array Mảng các danh mục (associative).
   */
  public function getAll()
  {
    $sql = "SELECT * FROM categories";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Lấy danh mục theo ID.
   *
   * @param int $id ID danh mục.
   * @return array|false Danh mục (associative) hoặc false nếu không tồn tại.
   */
  public function getById($id)
  {
    $sql = "SELECT * FROM categories WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      'id' => $id
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Lấy danh sách danh mục phân trang.
   *
   * @param int $page Trang hiện tại (mặc định 1).
   * @param int $limit Số item mỗi trang (mặc định 8).
   * @return array Mảng chứa items, limit, page, total_items, total_pages.
   */
  public function getPaginated($page = 1, $limit = 8)
  {
    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM categories ORDER BY id DESC LIMIT :limit OFFSET :offset";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      'limit' => $limit,
      'offset' => $offset
    ]);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalCategories = $this->getTotalCount();
    $totalPages = ceil($totalCategories / $limit);

    return [
      'items' => $categories,
      'limit' => $limit,
      'page' => $page,
      'total_items' => $totalCategories,
      'total_pages' => $totalPages,
    ];
  }

  /**
   * Lấy tổng số danh mục.
   *
   * @return int Tổng số danh mục.
   */
  public function getTotalCount()
  {
    $sql = "SELECT COUNT(*) FROM categories";
    $stmt = $this->db->query($sql);
    return $stmt->fetchColumn();
  }
}