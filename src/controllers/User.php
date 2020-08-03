<?php

namespace app\controllers;

class User {

  public function register() {
    require_once APPROOT . '/views/auth/register.php';
  }

  public function login() {
    require_once APPROOT . '/views/auth/login.php';
  }

}