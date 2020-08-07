<?php

namespace app\libraries;

class RouterBase {

  public static $validRoutes = array();
  public static $protectedRoutes = array();
  public static $apiEndpoints = array();

  public static function setRoutes($routes) {
    self::$validRoutes = $routes;
  }

  public static function setProtectedRoutes($routes) {
    self::$protectedRoutes = $routes;
  }

  public static function setApiEndpoints($routes) {
    self::$apiEndpoints = $routes;
  }

  public static function set($route, $callback) {
    $allowInvoke = true;
    $url = '';

    if (isset($_GET['url'])){


      
      $url = $_GET['url'];

      $actualUrl = explode('/', $_SERVER['REQUEST_URI']);

      if ($url == 'api') {
        if (array_key_exists(3, $actualUrl)) {
          $endpoint = $actualUrl[3];
          $url = $url . '/' . $endpoint;
        }
      }

      if ($url == 'admin') {
        if (array_key_exists(3, $actualUrl)) {
          $endpoint = $actualUrl[3];
          $url = $url . '/' . $endpoint;
          // echo '<p style="color: green;">'.$route.'</p>';
          // echo '<p style="color: blue;">'.$url.'</p>';
        }
      }
     

      if (in_array($url, self::$protectedRoutes)){
        if (!isset($_SESSION['user'])) {
          $allowInvoke = false;
          header("Location: " . URLROOT . '/admin/login');
        }
      } elseif (in_array($url, self::$apiEndpoints)) {

      } elseif (!in_array($url, self::$validRoutes)) {
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