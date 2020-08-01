<?php

namespace app\libraries;

use PDO;

class Database {

  private $host = DB_HOST;
  private $username = DB_USERNAME;
  private $password = DB_PASSWORD;
  private $dbname = DB_NAME;
  private $charset = "utf8mb4";

  public function connect (){

    try {
      $dsn = "mysql:host=".$this->host.";dbname=".$this->dbname.";charset=".$this->charset;
      
      $options = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
      );

      $pdo = new PDO($dsn, $this->username, $this->password, $options);
      return $pdo;

    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

}