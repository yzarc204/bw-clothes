<?php
require_once './models/BaseModel.php';

class ProductImage extends BaseModel
{
  public function create($productId, $imageUrl)
  {
    $sql = "INSERT INTO product_images(product_id, image_url)
            VALUES (:productId, :imageUrl)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
    $stmt->bindParam(':imageUrl', $imageUrl, PDO::PARAM_STR);
    $stmt->execute();
    return $this->db->lastInsertId();
  }

  public function delete($id)
  {
    $sql = "DELETE FROM product_images WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function getById($id)
  {
    $sql = "SELECT * FROM product_images WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getByProductId($productId)
  {
    $sql = "SELECT * FROM product_images WHERE product_id = :product_id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}