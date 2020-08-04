<?php

namespace app\models;
use app\libraries\Database as Database;

class User extends Database{

  private $username;

  public function __construct() {
  }

  public function setUser($username, $password) {
    $query = "INSERT INTO users(username, password) VALUES (?, ?)";
    $stmt = $this->connect()->prepare($query);
    $stmt->execute([$username, $password]);
  }

  public function getUser($username) {
    $query = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $this->connect()->prepare($query);
    $stmt->execute([$username]);

    if ($stmt->rowCount()) {
      $row = $stmt->fetch();
      return $row; 
    }
  }

}