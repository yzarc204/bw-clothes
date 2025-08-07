<?php
require_once 'models/BaseModel.php';

class Cart extends BaseModel
{
  public function addToCart($userId, $variantId, $quantity)
  {
    $sql = "INSERT INTO carts (user_id, variant_id, quantity)
                VALUES (:user_id, :variant_id, :quantity)
                ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam('variant_id', $variantId, PDO::PARAM_INT);
    $stmt->bindParam('quantity', $quantity, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function update($id, $quantity)
  {
    $sql = "UPDATE carts SET quantity = :quantity WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->bindParam('quantity', $quantity, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function delete($id)
  {
    $sql = "DELETE FROM carts WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function getCartDetailsByUserId($userId)
  {
    $sql = "SELECT 
              c.*, 
              c2.name AS color,
              s.name AS size, 
              pv.price, 
              pv.sale_price, 
              p.id as product_id, 
              p.name as product_name, 
              p.featured_image,
              COALESCE(pv.sale_price, pv.price) * c.quantity AS sub_total_amount
            FROM carts c 
            INNER JOIN product_variants pv 
              ON c.variant_id = pv.id 
            INNER JOIN products p 
              ON pv.product_id = p.id 
            INNER JOIN colors c2 
              ON pv.color_id = c2.id 
            INNER JOIN sizes s 
              ON pv.size_id = s.id 
            WHERE c.user_id = :user_id;
        ";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getCartTotalAmountByUserId($userId)
  {
    $sql = "SELECT SUM(COALESCE(pv.sale_price, pv.price) * c.quantity) AS total_amount
            FROM carts c 
            INNER JOIN product_variants pv 
              ON c.variant_id = pv.id 
            WHERE c.user_id = :user_id;
        ";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() ?? 0;
  }

  public function isset($id)
  {
    $sql = "SELECT COUNT(*) FROM carts WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
  }

  public function isOwnedByUser($id, $userId)
  {
    $sql = "SELECT COUNT(*) FROM carts WHERE user_id = :user_id AND id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
  }
}
