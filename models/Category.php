<?php
require_once './models/BaseModel.php';

<<<<<<< HEAD
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
=======
class Category extends BaseModel {
    public function getAll()
    {
        $sql = "SELECT * FROM categories";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
>>>>>>> bedc15886438c242270ef0a200f35f9949674d4b
}