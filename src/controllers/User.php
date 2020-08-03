<?php

namespace app\controllers;
use app\models\User as UserModel;

class User {

  public function __construct() {
    $this->userModel = new UserModel();
  }

  public function register() {

    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if(isset($post['register'])) {
      
      $username = trim($post['username']);
      $password = trim($post['password']);
      $confirmPassword = trim($post['confirm_password']);

      if($password != $confirmPassword) {
        $data['errorMessage'] = 'Passwords do not match';
      } 

      if (strlen($password) < 7 || strlen($confirmPassword) < 7) {
        $data['errorMessage'] = "Password is too short";
      } 
      
      if(strlen($username) < 3){
        $data['errorMessage'] = 'Username is too short';
      } else {
        $isTaken = $this->userModel->getUser($username);
        if (isset($isTaken)) {
          $data['errorMessage'] = 'Username is taken';
        }
      }
      
      if (!isset($data['errorMessage'])) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->userModel->setUser($username, $password);
        
        $_SESSION['user'] = $this->userModel->getUser($username);
        header("Location: " . URLROOT . '/members');
      }
    }

    require_once APPROOT . '/views/auth/register.php';
  }

  public function login() {
    require_once APPROOT . '/views/auth/login.php';
  }

  public function logout() {
    unset($_SESSION['user']);
    header("Location: " . URLROOT);
  }

}