<?php
require_once 'models/BaseModel.php'; // ✅ sửa lại tên file đúng là BaseModel

class CategoryModel extends BaseModel
{
    public function getAll()
    {
        $sql = "SELECT * FROM categories";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getBySlug($slug)
{
    $stmt = $this->conn->prepare("SELECT * FROM categories WHERE slug = ?");
    $stmt->execute([$slug]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function getById($id)
{
    $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
