<?php
require_once './models/BaseModel.php';

class Size extends BaseModel
{
  public function create($name)
  {
    $sql = "INSERT INTO sizes (name) VALUES (:name)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('name', $name);
    $stmt->execute();
    return $this->db->lastInsertId();
  }

  public function update($id, $name)
  {
    $sql = "UPDATE sizes SET name = :name WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->bindParam('name', $name, PDO::PARAM_STR);
    return $stmt->execute();

  }

  public function delete($id)
  {
    $sql = "DELETE FROM sizes WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function getById($id)
  {
    $sql = "SELECT * FROM sizes WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getAll()
  {
    $sql = "SELECT * FROM sizes ORDER BY id DESC";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function isset($id)
  {
    $sql = "SELECT COUNT(*) FROM sizes WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
  }
}