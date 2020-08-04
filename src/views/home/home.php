<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/nav.php'; ?>

<section class="app-home">
  <h1>Landlords</h1>

  <?php if(isset($_SESSION['user'])) : ?>
  <p>Logged in as <?= ucwords($_SESSION['user']->username); ?></p>
  <?php else : ?>
  <p>Login to get started</p>
  <p><a href="<?= URLROOT . '/login' ?>">Login</a></p>
  <?php endif; ?>
</section>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
