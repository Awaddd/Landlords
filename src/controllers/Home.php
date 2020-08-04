<?php

namespace app\controllers;

class Home {

  public function __construct() {
    require_once APPROOT . '/views/home/home.php';  
  }

}