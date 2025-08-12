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
    $stmt->bindParam('name', $name, PDO::PARAM_STR);
    $stmt->execute();
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
    $stmt->bindParam('name', $name, PDO::PARAM_STR);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
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
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
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
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getAllDetail()
  {
    // Lấy danh sách danh mục, số lượng sản phẩm và ảnh là ảnh của sản phẩm đầu tiên trong danh mục
    $sql = "SELECT 
              c.*,
              COUNT(p.id) AS total_products,
              MIN(p.featured_image) AS image
            FROM 
              categories c
            LEFT JOIN 
              products p ON c.id = p.category_id
            GROUP BY 
              c.id, c.name
            ORDER BY 
              c.name;";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Lấy danh sách danh mục phân trang.
   *
   * @param int $page Trang hiện tại (mặc định 1).
   * @param int $limit Số item mỗi trang (mặc định 8).
   * @return array Mảng chứa items, limit, page, total_items, total_pages.
   */
  public function getPaginated($page = 1, $limit = 8, $search = null)
  {
    $offset = ($page > 0) ? ($page - 1) * $limit : 0;

    // Đếm số lượng category
    $sql = "SELECT COUNT(*) FROM categories";
    if ($search) {
      $sql .= " WHERE name LIKE :search";
    }
    $stmt = $this->db->prepare($sql);
    if ($search) {
      $searchParam = '%' . $search . '%';
      $stmt->bindParam('search', $searchParam, PDO::PARAM_STR);
    }
    $stmt->execute();

    $totalCategories = $stmt->fetchColumn();
    $totalPages = ceil($totalCategories / $limit);

    // Lấy danh sách category
    $sql = "SELECT * FROM categories";
    if ($search) {
      $sql .= " WHERE name LIKE :search";
    }
    $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam('offset', $offset, PDO::PARAM_INT);
    if ($search) {
      $searchParam = '%' . $search . '%';
      $stmt->bindParam('search', $searchParam, PDO::PARAM_STR);
    }
    $stmt->execute();
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

  public function isset($id)
  {
    $sql = "SELECT COUNT(*) FROM categories WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
    ;
  }
}