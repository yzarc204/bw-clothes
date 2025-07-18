<?php

require_once './config.php';

class BaseModel
{
  private $host = DB_HOST;
  private $username = DB_USER;
  private $password = DB_PASS;
  private $dbname = DB_NAME;

  protected $db;

  public function __construct()
  {
    try {
      $this->db = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf-8", $this->username, $this->password);
    } catch (Exception $e) {
      die('Lỗi kết nối cơ sở dữ liệu');
    }
  }
}