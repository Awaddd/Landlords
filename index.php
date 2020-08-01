<?php 

require_once realpath("vendor/autoload.php");
require_once "config.php";

use app\controllers\Members as MemberController;

$memberController = new MemberController();
$memberController->showUser();