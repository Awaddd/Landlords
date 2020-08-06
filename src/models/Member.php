<?php

namespace app\models;
use app\libraries\Database as Database;

class Member extends Database {

  public function getAllMembers() {
    $stmt = $this->connect()->query("SELECT * FROM members");

    $row = $stmt->fetchAll();
    return array($row, $stmt->rowCount());
  }

  public function getMemberById($id) {
    $query = "SELECT * FROM members WHERE id = ?";
    $stmt = $this->connect()->prepare($query);
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row;
  }

  public function setMember($firstName, $lastName, $expiryDate) {
    $query = "INSERT INTO 
    members(first_name, last_name, expiry_date) 
    VALUES (?, ?, ?)";

    $stmt = $this->connect()->prepare($query);
    $stmt->execute([$firstName, $lastName, $expiryDate]);
    return $stmt->rowCount();
  }

  public function deleteMember($id) {
    $query = "DELETE FROM members WHERE id = ?";
    $stmt = $this->connect()->prepare($query);
    $stmt->execute([$id]);
  }

  public function editMember($id, $firstName, $lastName, $expiryDate) {
    $query = "UPDATE members SET first_name = ?, last_name = ?, expiry_date = ? WHERE id = ?";
    $stmt = $this->connect()->prepare($query);
    $stmt->execute([$firstName, $lastName, $expiryDate, $id]);
  }

}