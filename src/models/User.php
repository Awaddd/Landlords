<?php

namespace app\models;
use app\libraries\Database as Database;

class User extends Database{

  private $username;

  public function __construct ($username) {
    $this->username = $username;
  }

  public function getUsername() {
    return $this->username;
  }

}