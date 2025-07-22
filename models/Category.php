<?php
require_once './models/BaseModel.php';

class Category extends BaseModel
{
  public function create($name)
  {
    $sql = "INSERT INTO categories (name) VALUES (:name)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      'name' => $name
    ]);
    return $this->db->lastInsertId();
  }
}