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
  public function getAll()
  {
    $sql = "SELECT * FROM categories";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getBySlug($slug)
  {
    $stmt = $this->db->prepare("SELECT * FROM categories WHERE slug = ?");
    $stmt->execute([$slug]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  public function getById($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
