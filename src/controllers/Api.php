<?php

namespace app\controllers;
use app\models\Member as MemberModel;


class Api {

  public function __construct() {
    $this->memberModel = new MemberModel();
  }

  public function index() {


    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    $actualUrl = explode('/', $_SERVER['REQUEST_URI']);

    // if user passed in an ID in the url, find a member with that ID
    if (array_key_exists(4, $actualUrl)) {
      $param = $actualUrl[4];
      $member = $this->findOneMember($param);
    }

    if (empty($member)) {
      echo json_encode(array("message"=> "Member does not exist"));
    } else {
      echo json_encode($member);
    }

  }

  public function findOneMember($id) {
    return $this->memberModel->getMemberById($id);
  }

}