<?php
require_once './models/BaseModel.php';

class Category extends BaseModel {
    public function getAll()
    {
        $sql = "SELECT * FROM categories";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}