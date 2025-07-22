<?php
require_once './models/BaseModel.php';

class User extends BaseModel
{
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

  public function isUsernameExisted($username)
  {
    $sql = "SELECT COUNT(*) from users WHERE username = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$username]);
    $count = $stmt->fetchColumn();
    return $count > 0;
  }

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
}