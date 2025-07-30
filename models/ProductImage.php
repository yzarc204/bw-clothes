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
}