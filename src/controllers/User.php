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

      $data['errorMessage'] = $this->validateRegister($username, $password, $confirmPassword);
      
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
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if (isset($post['login'])) {
      $username = trim($post['username']);
      $password = trim($post['password']);

      $user = $this->userModel->getUser($username);

      $data['errorMessage'] = $this->validateLogin($username, $password, $user);
      
      if (!isset($data['errorMessage'])){
        $_SESSION['user'] = $user;
        header("Location: " . URLROOT . '/members');
      }

    }

    require_once APPROOT . '/views/auth/login.php';
  }

  public function logout() {
    unset($_SESSION['user']);
    session_destroy();
    header("Location: " . URLROOT);
  }

  public function validateRegister($username, $password, $confirmPassword) {

    if (empty($username)) {
      return "Username cannot be blank";
    } 
    if (empty($password)) {
      return "Password cannot be blank";
    } 
    if (empty($confirmPassword)) {
      return "Confirm Password cannot be blank";
    } 
    if(strlen($username) < 3){
      return 'Username is too short';
    } 

    $isTaken = $this->userModel->getUser($username);
    if (isset($isTaken)) {
      return 'Username is taken';
    }

    if (strlen($password) < 7 || strlen($confirmPassword) < 7) {
      return "Password is too short";
    } 

    if($password != $confirmPassword) {
      return 'Passwords do not match';
    } 
  }

  public function validateLogin($username, $password, $user) {

    $msg = 'Username or password is incorrect';
    if (empty($username)) {
      return "Username cannot be blank";
    } 
    if (empty($password)) {
      return "Password cannot be blank";
    } 
    if (!isset($user)) {
      return "User does not exist";
    } 
    if (!password_verify($password, $user->password)) {
      return "Incorrect password";
    } 
  }

}