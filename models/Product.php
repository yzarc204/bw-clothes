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
    // $stmt->bindParam('rating', 0, PDO::PARAM_INT);
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

  public function getPaginated($page = 1, $limit = 8)
  {
    $totalProducts = $this->getTotalCount();
    $totalPages = ceil($totalProducts / $limit);

    $page = max(1, (int) $page);
    $offset = ($page - 1) * $limit;

    $sql = "SELECT p.*, 
                       (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
                FROM products p
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam('offset', $offset, PDO::PARAM_INT);
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

  public function getTotalCount()
  {
    $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM products");
    $stmt->execute();
    return (int) $stmt->fetchColumn();
  }

  public function getAll()
  {
    $sql = "SELECT p.*, 
                       (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
                FROM products p";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getLimit($limit)
  {
    $limit = (int) $limit;
    $sql = "SELECT p.*, 
                       (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
                FROM products p
                ORDER BY id DESC
                LIMIT :limit";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getById($id)
  {
    $sql = "SELECT p.*, 
                       (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
                FROM products p
                WHERE p.id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getRelatedProducts($categoryId, $excludeId)
  {
    $sql = "SELECT p.*, 
                       (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
                FROM products p
                WHERE p.category_id = :category_id AND p.id != :exclude_id
                LIMIT 4";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
    $stmt->bindParam(':exclude_id', $excludeId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getVariantsByProductId($productId)
  {
    $sql = "SELECT pv.*, s.name AS size_name, c.name AS color_name
                FROM product_variants pv
                JOIN sizes s ON pv.size_id = s.id
                JOIN colors c ON pv.color_id = c.id
                WHERE pv.product_id = :product_id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getAllSizes()
  {
    $stmt = $this->db->prepare("SELECT * FROM sizes");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getAllColors()
  {
    $stmt = $this->db->prepare("SELECT * FROM colors");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getVariants($productId)
  {
    $sql = "SELECT * FROM product_variants WHERE product_id = :product_id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getImagesByProductId($productId)
  {
    $sql = "SELECT * FROM product_images WHERE product_id = :product_id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function searchProducts($keyword)
  {
    $sql = "SELECT p.*, 
                       (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
                FROM products p 
                WHERE p.name LIKE :keyword OR p.description LIKE :keyword";
    $stmt = $this->db->prepare($sql);
    $keywordParam = '%' . $keyword . '%';
    $stmt->bindParam(':keyword', $keywordParam, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getByCategoryId($categoryId)
  {
    $sql = "SELECT p.*, 
                       (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
                FROM products p
                WHERE p.category_id = :category_id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function isset($id)
  {
    $sql = "SELECT COUNT(*) FROM products WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function getProductDetailById($id)
  {
    $sql = "SELECT p.*, c.* FROM products p
            INNER JOIN categories c 
            ON c.id = p.category_id 
            WHERE id = :id";
    $stmt = $this->db->query($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }


  public function getProductDetailPaginated($page = 1, $limit = 8)
  {
    $offset = ($page >= 1) ? ($page - 1) * $limit : 0;

    $totalProducts = $this->getTotalCount();
    $totalPages = ceil($totalProducts / $limit);

    $sql = "SELECT p.*, c.*,
            p.id as product_id, 
            p.name as product_name,
            c.id as category_id,
            c.name as category_name
            FROM products p
            INNER JOIN categories c 
            ON c.id = p.category_id
            ORDER BY p.id DESC
            LIMIT :limit
            OFFSET :offset";
    $stmt = $this->db->prepare($sql);
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
}
