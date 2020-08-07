<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/nav.php'; ?>

<section class="app-auth">
  <h1>Register</h1>

  <form class="form" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="post">

    <p class="form-group-label"><strong>Acount Details</strong></p>
    <div class="form-input">
      <label for="username">Username</label>
      <input type="text" name="username" placeholder="Username">
    </div>
    
    <div class="form-input">
      <label for="password">Password</label>
      <input type="password" name="password" placeholder="Password">
    </div>

    <div class="form-input">
      <label for="confirm_password">Confirm Password</label>
      <input type="password" name="confirm_password" placeholder="Confirm Password">
    </div>

    <p class="form-group-label"><strong>Address</strong></p>
    <div class="form-input">
      <label for="address_line_1">Address line 1</label>
      <input type="text" name="address_line_1" placeholder="Address Line 1">
    </div>

    <div class="form-input">
      <label for="address_line_2">Address line 2</label>
      <input type="text" name="address_line_2" placeholder="Address Line 2">
    </div>

    <div class="form-input">
      <label for="address_line_3">Address line 3</label>
      <input type="text" name="address_line_3" placeholder="Address Line 3">
    </div>

    <div class="form-input">
      <label for="city">City</label>
      <input type="text" name="city" placeholder="City">
    </div>

    <div class="form-input">
      <label for="post_code">Post Code</label>
      <input type="text" name="post_code" placeholder="Post Code">
    </div>

    <input class="btn" type="submit" name="register" value="Sign up">
    <p>Have an account? <a href="<?= URLROOT . '/login' ?>">Login</a></p>

  </form>

  <?php if(isset($data['errorMessage'])): ?>
  <p style="color: red;"><?= $data['errorMessage'] ?></p>
  <?php endif; ?>
</section>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
