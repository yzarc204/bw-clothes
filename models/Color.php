<?php
require_once './models/BaseModel.php';

class Color extends BaseModel
{
  public function create($name)
  {
    $sql = "INSERT INTO colors (name) VALUES (:name)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('name', $name, PDO::PARAM_STR);
    $stmt->execute();
    return $this->db->lastInsertId();
  }

  public function update($id, $name)
  {
    $sql = "UPDATE colors SET name = :name WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->bindParam('name', $name, PDO::PARAM_STR);
    return $stmt->execute();
  }

  public function delete($id)
  {
    $sql = "DELETE FROM colors WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function getById($id)
  {
    $sql = "SELECT * FROM colors WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getAll()
  {
    $sql = "SELECT * FROM colors ORDER BY id DESC";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function isset($id)
  {
    $sql = "SELECT COUNT(*) FROM colors WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam('id', $id);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
  }
}