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

      $addressLine1 = trim($post['address_line_1']);
      $city = trim($post['city']);
      $postCode = trim($post['post_code']);

      if (isset($post['address_line_2'])) {
        $addressLine2 = trim($post['address_line_2']);
      }

      if (isset($post['address_line_3'])) {
        $addressLine3 = trim($post['address_line_3']);
      }

      // echo '<p>ad3 '. $addressLine3 . ', city: ' . $city .', postcode: '.$postCode.'</p>';
      // echo '<p> '. $addressLine1 . ' ' . $addressLine2 . ' ' . $addressLine3 . ' ' . $city . ' ' . $postCode .' </p>';

      $data['errorMessage'] = $this->validateRegister($username, $password, $confirmPassword, $addressLine1, $city, $postCode);
      if (!isset($data['errorMessage'])) {
        $response = $this->verifyAddress($addressLine1, $addressLine2, $addressLine3, $city, $postCode);
        echo '<p>verify address:  ' . $response->Text. ', ' . $response->Description . '</p>';
      }
      if (!isset($data['errorMessage'])) {
        
        $password = password_hash($password, PASSWORD_DEFAULT);
        $userDetails = [$username, $password];
        $address = [$addressLine1];
        if (!empty($addressLine2)) {
          array_push($address, $addressLine2);
        }
        if (!empty($addressLine3)) {
          array_push($address, $addressLine3);
        }
        array_push($address, $city);
        array_push($address, $postCode);

        // $insertId = $this->userModel->setAddress(...$address);
        // var_dump($insertId);
        // array_push($userDetails, $insertId);
        // $this->userModel->setUser(...$userDetails);
        
        // $_SESSION['user'] = $this->userModel->getUser($username);
        // header("Location: " . URLROOT . '/members');
      }
    }

    require_once APPROOT . '/views/auth/user/register.php';
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

    require_once APPROOT . '/views/auth/user/login.php';
  }

  public function logout() {
    unset($_SESSION['user']);
    session_destroy();
    header("Location: " . URLROOT);
  }

  public function validateRegister($username, $password, $confirmPassword, $addressLine1, $city, $postCode) {

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

    if (empty($addressLine1)) {
      return "Address Line 1 cannot be blank";
    } 
    
    if (empty($city)) {
      return "City cannot be blank";
    } 
    
    if (empty($postCode)) {
      return "Post Code cannot be blank";
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

  public function verifyAddress($addressLine1, $addressLine2, $addressLine3, $city, $postCode) { 
    $query = $addressLine1 . ', ' . $addressLine2 . ', ' . $addressLine3 . ', ' . $city . ', ' . $postCode;
    // $query = str_replace(' ', '%', $query);
    $arr = [$postCode, $addressLine1, $city];

    if (!empty($addressLine2)) {
      array_push($arr, $addressLine2);
    }
    if (!empty($addressLine3)) {
      array_push($arr, $addressLine3);
    }
    
    $query = implode(", ", $arr);
    var_dump($query);

    $reqUrl = 'https://api.addressy.com/Capture/Interactive/Find/v1.10/json3.ws?Key='. urlencode(API_KEY) .'&Text=' . urlencode($query);

    // $response = file_get_contents($reqUrl);
    $handler = curl_init();

    $options = [
      CURLOPT_URL => $reqUrl,
      CURLOPT_RETURNTRANSFER => true
    ];

    curl_setopt_array($handler, $options);
    $response = curl_exec($handler);

    curl_close($handler);
    
    $response = json_decode($response);
    var_dump($response);

    $address = array();

    foreach ($response->Items as $k => $address) {
      echo '<p style="color: green">'.$address->Id.'</p>';
      echo '<p style="color: blue">'.$address->Description.'</p>';
      echo '<p style="color: red">'.$address->Type.'</p>';
      echo '<p style="color: pink">'.$address->Text.'</p>';
      return $address;
    }

  }

}