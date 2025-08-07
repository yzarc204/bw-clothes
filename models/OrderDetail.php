<?php
require_once './models/BaseModel.php';

class OrderDetail extends BaseModel
{
  public function create($orderId, $variantId, $productName, $sizeName, $colorName, $price, $productImage, $quantity, $totalAmount)
  {
    $sql = "INSERT INTO order_details (order_id, variant_id, product_name, size_name, color_name, price, product_image, quantity, total_amount) 
            VALUES (:order_id, :variant_id, :product_name, :size_name, :color_name, :price, :product_image, :quantity, :total_amount)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('order_id', $orderId);
    $stmt->bindParam('variant_id', $variantId);
    $stmt->bindParam('product_name', $productName);
    $stmt->bindParam('size_name', $sizeName);
    $stmt->bindParam('color_name', $colorName);
    $stmt->bindParam('price', $price);
    $stmt->bindParam('product_image', $productImage);
    $stmt->bindParam('quantity', $quantity);
    $stmt->bindParam('total_amount', $totalAmount);
    return $stmt->execute();
  }
}