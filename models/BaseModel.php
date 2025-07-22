<?php
class BaseModel
{
    protected $conn;

    public function __construct()
    {
        $host = 'localhost';
        $dbname = 'bw_clothe';
        $username = 'root';
        $password = '';

<<<<<<< HEAD
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
=======
  public function __construct()
  {
    try {
      $this->db = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->username, $this->password);
    } catch (Exception $e) {
      die('Lỗi kết nối cơ sở dữ liệu');
>>>>>>> 72d9345d2c0a5e27d868e143df4e5e033c025d49
    }
}
