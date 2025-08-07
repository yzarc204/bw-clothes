<?php
require_once './models/BaseModel.php';

class Order extends BaseModel
{
  public function create($userId, $subTotal, $vatAmount, $shippingFee, $totalAmount, $customerName, $address, $phoneNumber)
  {
    $sql = "INSERT INTO orders (user_id, subtotal, vat_amount, shipping_fee, total_amount, customer_name, address, phone_number, order_time, status) 
            VALUES (:user_id, :subtotal, :vat_amount, :shipping_fee, :total_amount, :customer_name, :address, :phone_number, NOW(), 'processing')";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam('subtotal', $subTotal, PDO::PARAM_INT);
    $stmt->bindParam('vat_amount', $vatAmount, PDO::PARAM_INT);
    $stmt->bindParam('shipping_fee', $shippingFee, PDO::PARAM_INT);
    $stmt->bindParam('total_amount', $totalAmount, PDO::PARAM_INT);
    $stmt->bindParam('customer_name', $customerName, PDO::PARAM_STR);
    $stmt->bindParam('address', $address, PDO::PARAM_STR);
    $stmt->bindParam('phone_number', $phoneNumber);
    $stmt->execute();
    return $this->db->lastInsertId();
  }
}