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

    if (isset($post['add'])){
      $data['errorMessage'] = $this->addMember($post['first_name'], $post['last_name'], $post['expiry_date']);
    } 

    if (isset($post['edit'])){
      $data['errorMessage'] = $this->editMember($_POST['edit_id'], $post['first_name'], $post['last_name'], $post['expiry_date']);
    }

    if (isset($post['delete'])){
      $this->deleteMember($_POST['delete_id']);
    }


    $rowAndCount = $this->memberModel->getAllMembers();
    $data["members"] = $rowAndCount[0];
    $totalRows = $rowAndCount[1];

    $data['numPerPage'] = 5;
    $data['totalPages'] = ceil($totalRows / $data['numPerPage']);

    $_SESSION['totalRows'] = $totalRows;

    if (!isset($_SESSION['currentPage'])) {
      $_SESSION['currentPage'] = 1;
    }
    if (!isset($_SESSION['firstRow'])) {
      $_SESSION['firstRow'] = 0;
    }
    if (!isset($_SESSION['lastRow'])) {
      if ($totalRows <= $data['numPerPage']) {
        $_SESSION['lastRow'] = $totalRows;
      } else {
        $_SESSION['lastRow'] = 5;
      }
    }

    $_SESSION['sum'] = $data['totalPages'] * $data['numPerPage'];

    if (!isset($_SESSION['lastPage'])) {
      $_SESSION['lastPage'] = $data['totalPages']; 
    }

    if (isset($post['next_page'])){
      
      $_SESSION['currentPage']++;

      if ($_SESSION['currentPage'] == $data['totalPages']) {
        $_SESSION['firstRow'] += $data['numPerPage'];
        $_SESSION['lastRow'] = $_SESSION['totalRows'];
        
      } elseif ($_SESSION['currentPage'] < $data['totalPages']) {
        $_SESSION['firstRow'] += $data['numPerPage'];
        $_SESSION['lastRow'] += $data['numPerPage'];
      }

      if ($_SESSION['currentPage'] > $data['totalPages']) {
        $_SESSION['currentPage']--;
      }

   
    }

    if (isset($post['prev_page'])){

      if ($_SESSION['firstRow'] != 0 && $_SESSION['lastRow'] != 5) {

        if ($_SESSION['currentPage'] == $data['totalPages']) {
          $_SESSION['firstRow'] -= $data['numPerPage'];
          $_SESSION['lastRow'] = $_SESSION['sum'];
          $_SESSION['lastRow'] -= $data['numPerPage'];
          $_SESSION['currentPage']--;

        } else {
          $_SESSION['firstRow'] -= $data['numPerPage'];
          $_SESSION['lastRow'] -= $data['numPerPage'];

          $_SESSION['currentPage']--;
        }
      }

    }


    $actualUrl = explode('/', $_SERVER['REQUEST_URI']);
    
    if (array_key_exists(4, $actualUrl)) {
      $id = $actualUrl[3];
      $data['member'] = $this->memberModel->getMemberById($id);
      if (!empty($actualUrl[4]) && $actualUrl[4] == 'pdf' && !empty($data['member'])) {
        require_once(APPROOT . '/helpers/generatePDF.php');
      } elseif ($actualUrl[4] != "pdf" && $actualUrl[4] != '') {
        header("Location: " . URLROOT . '/members/' . $data['member']->id);
      } elseif (empty($data['member'])) {
        $data['message'] = 'Member does not exist';
        require_once APPROOT . '/views/other/notFound.php';
      } else {
        require_once APPROOT . '/views/members/showSingleMember.php';
      }
    }
    elseif(array_key_exists(3, $actualUrl)) {
      if (!empty($actualUrl[3])) {
        $id = $actualUrl[3];
        $data['member'] = $this->memberModel->getMemberById($id);
        if ($data['member']) {
          require_once APPROOT . '/views/members/showSingleMember.php';
        } else {
          $data['message'] = 'Member does not exist';
          require_once APPROOT . '/views/other/notFound.php';
        }
      } else {
        require_once APPROOT . '/views/members/manageMembers.php';
      }
    } else {
      require_once APPROOT . '/views/members/manageMembers.php';
    }
  
  }

  public function addMember($firstName, $lastName, $expiryDate) {
    $firstName = ucwords(strtolower($firstName));
    $firstName = trim($firstName);
    $lastName = ucwords(strtolower($lastName));
    $lastName = trim($lastName);
    $expiryDate = $expiryDate;

    $errorMessage = $this->validateMember($firstName, $lastName, $expiryDate);
    
    if (isset($errorMessage)) {
      return $errorMessage;
    } else {
      $this->memberModel->setMember($firstName, $lastName, $expiryDate);
      $_SESSION['totalRows'] += 1;

      if ($_SESSION['currentPage'] == $_SESSION['lastPage']) {    

        $_SESSION['sum'] = $_SESSION['lastPage'] * 5;

        if ($_SESSION['totalRows'] > $_SESSION['sum']) {

          $_SESSION['firstRow'] += 5;
          $_SESSION['lastRow'] = $_SESSION['totalRows'];
          $_SESSION['currentPage']++;
          $_SESSION['lastPage']++;

        } elseif ($_SESSION['totalRows'] > $_SESSION['lastRow']) {
          $_SESSION['lastRow'] = $_SESSION['totalRows'];
        }
        
      }
    }
  }

  public function editMember($id, $firstName, $lastName, $expiryDate) {
    $firstName = ucwords(strtolower($firstName));
    $firstName = trim($firstName);
    $lastName = ucwords(strtolower($lastName));
    $lastName = trim($lastName);
    $expiryDate = $expiryDate;

    $errorMessage = $this->validateMember($firstName, $lastName, $expiryDate);
    
    if (isset($errorMessage)) {
      return $errorMessage;
    } else {
      $this->memberModel->editMember($id, $firstName, $lastName, $expiryDate);
    }
  }

  public function deleteMember($id) {
    $this->memberModel->deleteMember($id);
    $this->setPaginationDefaults();
  }

  public function validateMember($firstName, $lastName, $expiryDate) {

    $len = 3;

    if (empty($firstName)) {
      return "First name cannot be blank";
    }

    if (empty($lastName)) {
      return "Last name cannot be blank";
    }
  
    if (strlen($firstName) < $len) {
      return "First name is too short";
    }

    if (strlen($lastName) < $len) {
      return "Last name is too short";
    }

    $expiryDateArray = explode('-', $expiryDate);
    $valid = checkdate($expiryDateArray[1], $expiryDateArray[2], $expiryDateArray[0]);
    
    if ($valid == false) {
      return "Date is invalid";
    } 

  }

  public function setPaginationDefaults() {
    $_SESSION['currentPage'] = 1;
    $_SESSION['firstRow'] = 0;
    $_SESSION["lastRow"] = 5;
    if ($_SESSION['totalRows'] <= 5) {
      $_SESSION['lastRow'] = $_SESSION['totalRows'] - 1;
    } 
    $_SESSION['lastPage'] = ceil($_SESSION['totalRows'] / 5);
  }

}