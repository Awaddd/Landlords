<?php

use app\libraries\RouterBase as RouterBase;
use app\controllers\Members as MemberController;
use app\controllers\Home as HomeController;

RouterBase::set('', function() {
  $homeController = new HomeController();
});

RouterBase::set('members', function() {
  $memberController = new MemberController();
  $memberController->showUser();
});


