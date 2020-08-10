<?php

namespace app\controllers;
use app\models\User as UserModel;

class User {

  public function __construct() {
    $this->userModel = new UserModel();
  }

  public function register() {
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if (isset($post['address'])) {
      $response = $this->retrieveAddress($post['address']);
      echo json_encode($response);
      return;
    }

    if(isset($post['post_code'])) {
      
      $postCode = trim($post['post_code']);

      $response = $this->verifyAddress($postCode);

      $data["address"] = array();

      foreach ($response->Items as $k => $a) {
        // $addressArray = array();

        // $description = explode(",", $a->Description);
        // $addressLine3 = $description[0];
        // $postCode = $description[1];

        $text = explode(",", $a->Text);
        $addressLine1 = $text[0] . ", " . $text[1];
        // $addressLine2 = $text[2];

        $address = array();

        $address["addressLine1"] = $addressLine1;
        // $address["addressLine2"] = $addressLine2;
        // $address["addressLine3"] = $addressLine3;
        // $address["post_code"] = $postCode;
        $address["id"] = $a->Id;

        array_push($data["address"], $address);
        $data["post_code"] = $postCode;

      }
    }


    if(isset($post['register'])) {
      
      $username = trim($post['username']);
      $password = trim($post['password']);
      $confirmPassword = trim($post['confirm_password']);

      $addressLine1 = trim($post['address_line_1']);
      $city = trim($post['city']);
      $postCode = trim($post['actual_post_code']);

      if (isset($post['address_line_2'])) {
        $addressLine2 = trim($post['address_line_2']);
      }

      if (isset($post['address_line_3'])) {
        $addressLine3 = trim($post['address_line_3']);
      }

      // echo '<p>ad3 '. $addressLine3 . ', city: ' . $city .', postcode: '.$postCode.'</p>';
      // echo '<p> '. $addressLine1 . ' ' . $addressLine2 . ' ' . $addressLine3 . ' ' . $city . ' ' . $postCode .' </p>';

      // $data['errorMessage'] = $this->validateRegister($username, $password, $confirmPassword, $postCode);
      $data['errorMessage'] = $this->validateRegister($username, $password, $confirmPassword, $addressLine1, $city, $postCode);
      if (!isset($data['errorMessage'])) {

        // where verify address was before

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

        $insertId = $this->userModel->setAddress(...$address);
        // var_dump($insertId);
        array_push($userDetails, $insertId);
        $this->userModel->setUser(...$userDetails);
        
        $_SESSION['user'] = $this->userModel->getUser($username);
        header("Location: " . URLROOT . '/members');
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

  // public function validateRegister($username, $password, $confirmPassword, $postCode) {
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

  public function verifyAddress($postCode) { 
    // $query = $addressLine1 . ', ' . $addressLine2 . ', ' . $addressLine3 . ', ' . $city . ', ' . $postCode;
    $query = $postCode;
    // $arr = [$postCode];

    // $query = implode(", ", $arr);

    $reqUrl = 'https://api.addressy.com/Capture/Interactive/Find/v1.10/json3.ws?Key='. urlencode(API_KEY) .'&Text=' . urlencode($query);

    $handler = curl_init();

    $options = [
      CURLOPT_URL => $reqUrl,
      CURLOPT_RETURNTRANSFER => true
    ];

    curl_setopt_array($handler, $options);
    $response = curl_exec($handler);

    curl_close($handler);
    
    $response = json_decode($response);
    // var_dump($response);

    foreach ($response->Items as $k => $address) {
      // echo '<h2 style="color: green">'.$address->Id.'</h2>';
    }

    // search using the same service, but this time pass in the returned address id as a container
    $container = $address->Id;
    // echo 'Container: <br>';
    // var_dump($container);
    // echo '<br>';

    $reqUrl = 'https://api.addressy.com/Capture/Interactive/Find/v1.10/json3.ws?Key='. urlencode(API_KEY) .'&Text=' . urlencode($query) . '&Container=' . urlencode($container);

    $handler = curl_init();
    $options = [
      CURLOPT_URL => $reqUrl,
      CURLOPT_RETURNTRANSFER => true
    ];

    curl_setopt_array($handler, $options);
    $response = curl_exec($handler);
    curl_close($handler);
    $response = json_decode($response);

    // print_r($response->Items);
    return $response;

  }

  public function retrieveAddress($id) {
    // $reqUrl = 'https://api.addressy.com/Capture/Interactive/Retrieve/v1.00/json3.ws?Key=AA11-AA11-AA11-AA11&Id=GBR|52509479';
    $reqUrl = 'https://api.addressy.com/Capture/Interactive/Retrieve/v1.00/json3.ws?Key='. urlencode(API_KEY) .'&id=' . urlencode($id);
    $response = $this->getApi($reqUrl);
    return $response;
  }

  public function getApi($reqUrl) {

    $handler = curl_init();

    $options = [
      CURLOPT_URL => $reqUrl,
      CURLOPT_RETURNTRANSFER => true
    ];

    curl_setopt_array($handler, $options);
    $response = curl_exec($handler);
    curl_close($handler);
    return json_decode($response);
    
  }

}