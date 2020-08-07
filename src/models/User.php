<?php

namespace app\models;
use app\libraries\Database as Database;

class User extends Database{

  private $username;

  public function __construct() {
  }

  public function getUser($username) {
    $query = "SELECT id, username, password FROM users WHERE username = ?";
    // $query = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $this->connect()->prepare($query);
    $stmt->execute([$username]);

    if ($stmt->rowCount()) {
      $row = $stmt->fetch();
      return $row; 
    }
  }

  public function setUser($username, $password, $address) {
    $query = "INSERT INTO users(username, password, address_id) VALUES (?, ?, ?)";
    // $query = "INSERT INTO users(username, password) VALUES (?, ?)";
    $stmt = $this->connect()->prepare($query);
    $stmt->execute([$username, $password, $address]);
  }
  
  public function setAddress($addressLine1, $addressLine2, $addressLine3, $city, $postCode) {
    $query = "INSERT INTO address 
    (address_line_1, address_line_2, address_line_3, city, post_code) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->connect()->prepare($query);
    $stmt->execute([$addressLine1, $addressLine2, $addressLine3, $city, $postCode]);
    $id = $this->connect()->lastInsertId();
    return $id;
  }

}