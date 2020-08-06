<?php

use app\libraries\RouterBase as RouterBase;
use app\controllers\Home as HomeController;
use app\controllers\Members as MemberController;
use app\controllers\User as UserController;
use app\controllers\Api as ApiController;

RouterBase::setRoutes(['', 'register', 'login', 'logout']);
RouterBase::setProtectedRoutes(['members']);
RouterBase::setApiEndpoints(['api/members']);

RouterBase::set('', function() {
  $homeController = new HomeController();
});

RouterBase::set('members', function() {
  $memberController = new MemberController();
  $memberController->index();
});

RouterBase::set('register', function() {
  $userController = new UserController();
  $userController->register();
});

RouterBase::set('login', function() {
  $userController = new UserController();
  $userController->login();
});

RouterBase::set('logout', function() {
  $userController = new UserController();
  $userController->logout();
});


// Requests to the API

RouterBase::set('api/members', function() {
  $api = new ApiController();
  $api->index();
});