<?php
require_once './models/BaseModel.php';

class User extends BaseModel
{
  public function create($username, $password, $name)
  {
    $sql = "INSERT INTO users (username, password, name) VALUES (:username, MD5(:password), :name)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      'username' => $username,
      'password' => $password,
      'name' => $name
    ]);
    return $this->db->lastInsertId();
  }

  public function update($id, $username, $name, $isAdmin)
  {
    $sql = "UPDATE users SET username = :username, name = :name, is_admin = :is_admin WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->bindParam('username', $username, PDO::PARAM_STR);
    $stmt->bindParam('name', $name, PDO::PARAM_STR);
    $stmt->bindParam('is_admin', $isAdmin, PDO::PARAM_INT);
    $stmt->execute();
  }

  public function getByUserAndPass($username, $password)
  {
    $sql = "SELECT * FROM users WHERE username = :username AND password = MD5(:password) LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      'username' => $username,
      'password' => $password
    ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
  }

  public function getById($id)
  {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
  }

  public function getByUsername($username)
  {
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
  }

  public function getPaginated($page, $limit, $search = null)
  {
    $offset = ($page - 1) * $limit;

    // Tính tổng số user
    $sql = "SELECT COUNT(*) FROM users";
    if ($search) {
      $sql .= " WHERE username LIKE :search OR name LIKE :search OR email LIKE :search";
    }
    $stmt = $this->db->prepare($sql);
    if ($search) {
      $searchParam = "%$search%";
      $stmt->bindParam(':search', $searchParam);
    }
    $stmt->execute();

    $totalUsers = $stmt->fetchColumn();
    $totalPages = ceil($totalUsers / $limit);

    // Lấy danh sách user
    $sql = "SELECT * FROM users";
    if ($search) {
      $sql .= " WHERE username LIKE :search OR name LIKE :search OR email LIKE :search";
    }
    $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";
    $stmt = $this->db->prepare($sql);
    if ($search) {
      $searchParam = "%$search%";
      $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
    }
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
      'items' => $users,
      'total_pages' => $totalPages,
      'total_items' => $totalUsers,
      'limit' => $limit,
      'page' => $page
    ];
  }

  public function isset($id)
  {
    $sql = "SELECT COUNT(*) FROM users WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
  }

  public function isUsernameExisted($username)
  {
    $sql = "SELECT COUNT(*) from users WHERE username = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$username]);
    $count = $stmt->fetchColumn();
    return $count > 0;
  }
}