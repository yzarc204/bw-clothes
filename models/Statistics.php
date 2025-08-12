<?php
require_once './models/BaseModel.php';

class Statistics extends BaseModel
{
  public function getTotalPurchasedProduct()
  {
    $sql = "SELECT SUM(quantity) FROM order_details
            INNER JOIN orders ON orders.id = order_details.order_id
            WHERE orders.status = 'received'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function getTotalRevenue()
  {
    $sql = "SELECT SUM(total_amount) FROM orders WHERE status = 'received'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function getTotalOrder()
  {
    $sql = "SELECT COUNT(*) FROM orders";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function getTotalSuccessOrder()
  {
    $sql = "SELECT COUNT(*) FROM orders WHERE status = 'received'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function getTotalCancelOrder()
  {
    $sql = "SELECT COUNT(*) FROM orders WHERE status = 'canceled'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function getTotalUser()
  {
    $sql = "SELECT COUNT(*) FROM users";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function getTotalProduct()
  {
    $sql = "SELECT COUNT(*) FROM products";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function getTotalVariant()
  {
    $sql = "SELECT COUNT(*) FROM product_variants";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  }
}