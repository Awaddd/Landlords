<!DOCTYPE html>
<html>
<html lang="en">
  <head?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,
    initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="<?= URLROOT . '/public/css/main.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?= URLROOT . '/public/css/members.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?= URLROOT . '/public/css/auth.css' ?>">
    <title><?= SITENAME ?></title>
  </head>
  <body>  
    <nav class="app-nav">
      <ul class="app-nav-wrapper">
        <li class="app-nav-link">
          <a href="<?= URLROOT ?>">Home |</a>
          <!-- <a href="<?= URLROOT . '/members' ?>">Members</a> -->
          <a href="<?= URLROOT . '/login' ?>">Login|</a>
          <a href="<?= URLROOT . '/register' ?>">Register</a>
          <a href="<?= URLROOT . '/logout' ?>">Logout</a>
        </li>
      </ul>
    </nav>