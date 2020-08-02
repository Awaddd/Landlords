<?php

namespace app\libraries;

class RouterBase {

  public static $validRoutes = array();

  public static function set($route, $callback) {
    self::$validRoutes[] = $route;

    $url = '';

    if (isset($_GET['url'])){
      $url = $_GET['url'];
    }

    if ($url == $route) {
      $isValid = true;
      $callback->__invoke();
    } 

  }
}