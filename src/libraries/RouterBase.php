<?php

namespace app\libraries;

class RouterBase {

  public static $validRoutes = array();
  public static $protectedRoutes = array();

  public static function setRoutes($routes) {
    self::$validRoutes = $routes;
  }

  public static function setProtectedRoutes($routes) {
    self::$protectedRoutes = $routes;
  }

  public static function set($route, $callback) {
    $allowInvoke = true;
    $url = '';

    if (isset($_GET['url'])){
      
      $url = $_GET['url'];

      if (in_array($_GET['url'], self::$protectedRoutes)){
        if (!isset($_SESSION['user'])) {
          $allowInvoke = false;
          header("Location: " . URLROOT . '/login');
        }
      } elseif (!in_array($_GET['url'], self::$validRoutes)) {
        require_once APPROOT . '/views/other/notFound.php';
        $allowInvoke = false;
      }

    }

    if ($url == $route) {
      if($allowInvoke == true) {
        $callback->__invoke();
      }
    } elseif (strtolower($url) == strtolower($route)){
      // redirect to lowercase url of the same route
      header("Location: " . URLROOT . '/' . $route);
    }
    
  }
}