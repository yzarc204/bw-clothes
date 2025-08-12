<?php
require_once './models/BaseModel.php';
require_once './enums/OrderStatusEnum.php';

class Order extends BaseModel
{
  public function create($userId, $subTotal, $vatAmount, $shippingFee, $totalAmount, $customerName, $address, $phoneNumber)
  {
    $sql = "INSERT INTO orders (user_id, subtotal, vat_amount, shipping_fee, total_amount, customer_name, address, phone_number, order_time, status) 
            VALUES (:user_id, :subtotal, :vat_amount, :shipping_fee, :total_amount, :customer_name, :address, :phone_number, NOW(), 'pending')";
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

  public function updateStatus($id, $status)
  {
    $sql = "UPDATE orders SET status = :status";
    if ($status == OrderStatusEnum::DELIVERING) {
      $sql .= ", shipping_time = NOW()";
    } else if ($status == OrderStatusEnum::RECEIVED) {
      $sql .= ", delivered_time = NOW()";
    }
    $sql .= " WHERE id = :id";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->bindParam('status', $status, PDO::PARAM_STR);
    return $stmt->execute();
  }

  public function getById($id)
  {
    $sql = "SELECT * FROM orders WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getDetailById($id)
  {
    $sql = "SELECT 
              orders.*,
              users.username
            FROM orders
            INNER JOIN order_details
              ON orders.id = order_details.order_id
            INNER JOIN users
              ON orders.user_id = users.id
            WHERE orders.id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getDetailPaginated($page = 1, $limit = 10)
  {
    $offset = ($page - 1) * $limit;

    $sql = "SELECT COUNT(*) FROM orders";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    $totalOrders = $stmt->fetchColumn();
    $totalPages = ceil($totalOrders / $limit);

    $sql = "SELECT 
              orders.*,
              users.username,
              SUM(order_details.quantity) AS total_items
            FROM orders
            INNER JOIN order_details
              ON orders.id = order_details.order_id
            INNER JOIN users
              ON orders.user_id = users.id
            GROUP BY orders.id 
            ORDER BY orders.id DESC
            LIMIT :limit
            OFFSET :offset";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam('limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
      'items' => $orders,
      'total_pages' => $totalPages,
      'total_items' => $totalOrders,
      'limit' => $limit,
      'page' => $page
    ];
  }

  public function getPaginatedByUserId($userId, $page = 1, $limit = 10)
  {
    // Tính tổng số đơn hàng
    $sql = "SELECT COUNT(*) FROM orders WHERE user_id = :user_id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $totalOrders = $stmt->fetchColumn();
    $offset = ($page - 1) * $limit;
    $totalPages = ceil($totalOrders / $limit);

    // Lấy danh sách đơn hàng với phân trang
    $sql = "SELECT 
              orders.*,
              SUM(order_details.quantity) AS total_items
            FROM orders
            INNER JOIN order_details
              ON orders.id = order_details.order_id
            WHERE 
              user_id = :user_id 
            GROUP BY orders.id 
            ORDER BY id DESC
            LIMIT :limit
            OFFSET :offset";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam('offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam('limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
      'items' => $orders,
      'total_pages' => $totalPages,
      'total_items' => $totalOrders,
      'limit' => $limit,
      'page' => $page
    ];
  }

  public function isset($id)
  {
    $sql = "SELECT COUNT(*) FROM orders WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
  }

  public function isOwnedByUser($id, $userId)
  {
    $sql = "SELECT COUNT(*) FROM orders WHERE id = :id AND user_id = :user_id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->bindParam('user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
  }
}