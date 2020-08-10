<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/nav.php'; ?>

<section class="app-auth">
  <h1>Register</h1>

  <form class="form" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="post">

    <div class="form-input">
      <label for="post_code">Post Code</label>
      <?php if(isset($data["post_code"])) : ?>
      <input type="text" name="post_code" value="<?= $data["post_code"] ?>" placeholder="Post Code">
      <?php else : ?>
      <input type="text" name="post_code" placeholder="Post Code">
      <?php endif; ?>
      <input class="btn" type="submit" name="find_address" value="Find Address">
    </div>

  </form>
  <br>
  <form id="selectAddressForm" class="form" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
  
    <?php if(isset($data['address'])) : ?>

    <div class="form-input">
      <label for="address_line_1">Select Address</label>
      <select name="select_address" id="selectAddress">
        <option selected disabled hidden>Select Address</option>
      <?php foreach($data['address'] as $key => $address) : ?>
        <option value="<?= $address["id"] ?>" ><?= $address["addressLine1"] ?></option>
      <?php endforeach ?>
      </select>
    </div>

    <?php endif; ?>


  </form>
  <form class="form" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="post">

  <?php if(isset($address)) : ?>

    <p class="form-group-label"><strong>Address</strong></p>

    <div class="form-input">
      <label for="address_line_1">Address line 1</label>
      <input type="text" name="address_line_1" id="line1" placeholder="Address Line 1">
    </div>

    <div class="form-input">
      <label for="address_line_2">Address line 2</label>
      <input type="text" name="address_line_2" id="line2" placeholder="Address Line 2">
    </div>

    <div class="form-input">
      <label for="address_line_3">Address line 3</label>
      <input type="text" name="address_line_3" id="line3" placeholder="Address Line 3">
    </div>

    <div class="form-input">
      <label for="address_line_3">Town/City</label>
      <input type="text" name="city" id="city" placeholder="City">
    </div>

    <div class="form-input">
      <label for="city">Post Code</label>
      <input type="text" name="actual_post_code" id="postCode" placeholder="Post Code">
    </div>

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

    <input class="btn" type="submit" name="register" value="Sign up">
    <?php endif; ?>
  </form>

  <p>Have an account? <a href="<?= URLROOT . '/login' ?>">Login</a></p>


  <?php if(isset($data['errorMessage'])): ?>
  <p style="color: red;"><?= $data['errorMessage'] ?></p>
  <?php endif; ?>
</section>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
