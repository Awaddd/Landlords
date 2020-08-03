<?php

namespace app\models;
use app\libraries\Database as Database;

class Member extends Database {

  public function getAllMembers() {
    $stmt = $this->connect()->query("SELECT * FROM members");

    $row = $stmt->fetchAll();
    return $row;
  }

  public function getMembersWithCountCheck() {
    $id = 2;
    $first_name = "Alex";

    $stmt = $this->connect()->prepare("SELECT * FROM members WHERE id = ? AND first_name = ?");
    $stmt->execute([$id, $first_name]);

    if ($stmt->rowCount()) {
      $row = $stmt->fetch();
      return $row; 
    }
  
  }

  public function setMember($first_name, $last_name, $expiry_date) {
    $query = "INSERT INTO 
    members(first_name, last_name, expiry_date) 
    VALUES (?, ?, ?)";

    $stmt = $this->connect()->prepare($query);
    $stmt->execute([$first_name, $last_name, $expiry_date]);
  }

  public function deleteMember($id) {
    $query = "DELETE FROM members WHERE id = ?";
    $stmt = $this->connect()->prepare($query);
    $stmt->execute([$id]);
  }

  public function editMember($id, $first_name, $last_name, $expiry_date) {
    $query = "UPDATE members SET first_name = ?, last_name = ?, expiry_date = ? WHERE id = ?";
    $stmt = $this->connect()->prepare($query);
    $stmt->execute([$first_name, $last_name, $expiry_date, $id]);
  }

}