<?php
require_once './models/BaseModel.php';

class Product extends BaseModel
{
  public function create($name, $categoryId, $description, $featuredImage)
  {
    $sql = "INSERT INTO products (name, category_id, description, featured_image, rating) 
            VALUES (:name, :category_id, :description, :featured_image, 0)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('name', $name, PDO::PARAM_STR);
    $stmt->bindParam('category_id', $categoryId, PDO::PARAM_INT);
    $stmt->bindParam('description', $description, PDO::PARAM_STR);
    $stmt->bindParam('featured_image', $featuredImage, PDO::PARAM_STR);
    $stmt->execute();
    return (int) $this->db->lastInsertId();
  }

  public function update($id, $name, $categoryId, $description, $featuredImage)
  {
    $sql = "UPDATE products SET 
            name = :name, 
            category_id = :category_id, 
            description = :description, 
            featured_image = :featured_image, 
            rating = 0
            WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('name', $name, PDO::PARAM_STR);
    $stmt->bindParam('category_id', $categoryId, PDO::PARAM_INT);
    $stmt->bindParam('description', $description, PDO::PARAM_STR);
    $stmt->bindParam('featured_image', $featuredImage, PDO::PARAM_STR);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function delete($id)
  {
    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function getById($id)
  {
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getDetailById($id)
  {
    $sql = "SELECT 
              p.id,
              p.name,
              p.description,
              p.featured_image,
              p.rating,
              c.name AS category_name,
              MIN(COALESCE(pv.sale_price, pv.price)) AS min_price,
              MAX(COALESCE(pv.sale_price, pv.price)) AS max_price
          FROM 
              products p
          LEFT JOIN 
              categories c ON p.category_id = c.id
          LEFT JOIN 
              product_variants pv ON p.id = pv.product_id
          WHERE p.id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getDetailLimit($limit = 8)
  {
    $sql = "SELECT 
              p.id,
              p.name,
              p.description,
              p.featured_image,
              p.rating,
              c.name AS category_name,
              MIN(COALESCE(pv.sale_price, pv.price)) AS min_price,
              MAX(COALESCE(pv.sale_price, pv.price)) AS max_price
          FROM 
              products p
          LEFT JOIN 
              categories c ON p.category_id = c.id
          LEFT JOIN 
              product_variants pv ON p.id = pv.product_id
          GROUP BY 
              p.id, p.name, p.description, p.featured_image, p.rating, c.name
          ORDER BY 
              p.id DESC
          LIMIT :limit";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getDetailPaginated($page = 1, $limit = 8, $search = null)
  {
    $offset = ($page >= 1) ? ($page - 1) * $limit : 0;

    // Tính tổng số lượng sản phẩm
    $sql = "SELECT COUNT(*) FROM products";
    if ($search) {
      $sql .= " WHERE name LIKE :search";
    }
    $stmt = $this->db->prepare($sql);
    if ($search) {
      $searchParam = '%' . $search . '%';
      $stmt->bindParam('search', $searchParam, PDO::PARAM_STR);
    }
    $stmt->execute();

    $totalProducts = $stmt->fetchColumn();
    $totalPages = ceil($totalProducts / $limit);

    $sql = "SELECT 
              p.id,
              p.name,
              p.description,
              p.featured_image,
              p.rating,
              c.name AS category_name,
              MIN(COALESCE(pv.sale_price, pv.price)) AS min_price,
              MAX(COALESCE(pv.sale_price, pv.price)) AS max_price
          FROM 
              products p
          LEFT JOIN 
              categories c ON p.category_id = c.id
          LEFT JOIN 
              product_variants pv ON p.id = pv.product_id";

    if ($search) {
      $sql .= " WHERE p.name LIKE :search";
    }

    $sql .= " GROUP BY 
              p.id,
              p.name,
              p.description,
              p.featured_image,
              p.rating,
              c.name
          ORDER BY 
              p.id DESC
          LIMIT :limit 
          OFFSET :offset";
    $stmt = $this->db->prepare($sql);
    if ($search) {
      $searchParam = '%' . $search . '%';
      $stmt->bindParam('search', $searchParam, PDO::PARAM_STR);
    }
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
      'items' => $products,
      'total_pages' => $totalPages,
      'total_items' => $totalProducts,
      'limit' => $limit,
      'page' => $page
    ];
  }

  public function isset($id)
  {
    $sql = "SELECT COUNT(*) FROM products WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return (bool) $stmt->fetchColumn();
  }

  public function getTotalCount()
  {
    $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM products");
    $stmt->execute();
    return (int) $stmt->fetchColumn();
  }
}
