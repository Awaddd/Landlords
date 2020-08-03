<?php 

namespace app\controllers;
use app\models\User as UserModel;
use app\models\Member as MemberModel;

class Members {

  public function __construct() {
    $this->memberModel = new MemberModel();
  }

  public function index() {

    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if (isset($post['submit'])){
      $this->addMember($post['first_name'], $post['last_name'], $post['expiry_date']);
    } 

    if (isset($post['edit'])){
      $this->editMember($_POST['edit_id'], $post['first_name'], $post['last_name'], $post['expiry_date']);
    }

    if (isset($post['delete'])){
      $this->deleteMember($_POST['delete_id']);
    }

    $data = [
      "members" => $this->memberModel->getAllMembers()
    ]; 

    require_once APPROOT . '/views/members/manageMembers.php';

  }

  public function addMember($firstName, $lastName, $expiryDate) {
    $firstName = ucwords(strtolower($firstName));
    $firstName = trim($firstName);
    $lastName = ucwords(strtolower($lastName));
    $lastName = trim($lastName);
    $expiryDate = $expiryDate;
    $this->memberModel->setMember($firstName, $lastName, $expiryDate);
  }

  public function editMember($id, $firstName, $lastName, $expiryDate) {
    $firstName = ucwords(strtolower($firstName));
    $firstName = trim($firstName);
    $lastName = ucwords(strtolower($lastName));
    $lastName = trim($lastName);
    $expiryDate = $expiryDate;
    $this->memberModel->editMember($id, $firstName, $lastName, $expiryDate);
  }

  public function deleteMember($id) {
    $this->memberModel->deleteMember($id);
  }

}