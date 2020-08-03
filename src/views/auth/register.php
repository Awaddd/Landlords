<?php require_once APPROOT . '/views/inc/header.php'; ?>

<section class="app-auth">
  <h1>Register</h1>

  <form class="form" action="<?php $_SERVER['PHP_SELF'];?>" method="post">

    <div class="form-input">
      <label for="username">Username</label>
      <input type="text" name="username" placeholder="Username">
    </div>
    
    <div class="form-input">
      <label for="username">Password</label>
      <input type="password" name="password" placeholder="Password">
    </div>

    <div class="form-input">
      <label for="username">Confirm Password</label>
      <input type="password" name="confirm_password" placeholder="Confirm Password">
    </div>

    <input class="btn" type="submit" name="register" value="Sign up">
    <p>Have an account? <a href="<?= URLROOT . '/login' ?>">Login</a></p>

  </form>
</section>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
