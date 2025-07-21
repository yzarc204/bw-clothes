<?php
require_once './models/BaseModel.php';

class User extends BaseModel
{
  public function getByUserAndPass($username, $password)
  {
    $sql = "SELECT * FROM users WHERE $username = :username AND password = MD5(:password)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      'username' => $username,
      'password' => $password
    ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ?? null;
  }

  public function getById($id)
  {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    $user = $stmt->execute([$id]);
    return $user;
  }
}