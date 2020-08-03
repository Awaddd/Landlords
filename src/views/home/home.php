<?php require_once APPROOT . '/views/inc/header.php'; ?>

<section class="app-home">
  <h1>Welcome to the landlords app</h1>
  <p>Login to get started</p>
  <p><a href="<?= URLROOT . '/login' ?>">Login</a></p>
  <?php if(isset($_SESSION['user'])) {
    echo $_SESSION['user']->username;
  }
  ?>
</section>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
