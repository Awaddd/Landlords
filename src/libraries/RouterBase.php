<?php

namespace app\libraries;

class RouterBase {

  public static $validRoutes = array();

  public static function setRoutes($routes) {
    self::$validRoutes = $routes;
  }

  public static function set($route, $callback) {
    $url = '';

    if (isset($_GET['url'])){
      
      $url = $_GET['url'];

      if (!in_array($_GET['url'], self::$validRoutes)) {
        require_once APPROOT . '/views/other/notFound.php';
      }

    }

    if ($url == $route) {
      $callback->__invoke();
    } elseif (strtolower($url) == strtolower($route)){
      // redirect to lowercase url of the same route
      header("Location: " . URLROOT . '/' . $route);
    }
    
  }
}