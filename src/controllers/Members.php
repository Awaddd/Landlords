<?php 

namespace app\controllers;
use app\models\User as UserModel;
use app\models\Member as MemberModel;

class Members {

  public function showUser() {

    try {
      $userModel = new UserModel("Awad");
      $MemberModel = new MemberModel();

      $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      if (isset($post['submit'])){
        $first_name = $post['first_name'];
        $last_name = $post['last_name'];
        $MemberModel->setMember($first_name, $last_name, '2020-08-06 00:00:00');
      } 

      if (isset($post['edit'])){
        $MemberModel->editMember($_POST['edit_id'], $_POST['first_name'], $_POST['last_name']);
      }

      if (isset($post['delete'])){
        $MemberModel->deleteMember($post['delete_id']);
      }

      
      $data = [
        "user" => $userModel->getUsername(),
        "members" => $MemberModel->getAllMembers()
        // $user = $MemberModel->getMembersWithCountCheck();
      ]; 

      require_once APPROOT . '/views/members/manageMembers.php';
    
    } catch (TypeError $e) {
      echo "Error: " . $e->getMessage();
    }
  }

}