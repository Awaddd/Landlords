<nav class="app-nav">
  <ul class="app-nav-wrapper">
    <li class="app-nav-link">
      <a href="<?= URLROOT ?>">Home |</a>
      <?php if (!isset($_SESSION['user'])) : ?>
      <a href="<?= URLROOT . '/login' ?>">Login |</a>
      <a href="<?= URLROOT . '/register' ?>">Register</a>
      <?php else : ?>
      <a href="<?= URLROOT . '/members' ?>">Members |</a>
      <a href="<?= URLROOT . '/logout' ?>">Logout</a>
      <?php endif; ?>
    </li>
  </ul>
</nav>