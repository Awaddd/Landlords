<form class="form" id="add-member-form" method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
  <div class="form-input">
    <label for="first_name">First name</label>
    <input type="text" placeholder="First Name" name="first_name">
  </div>

  <div class="form-input">
    <label for="last_name">Last name</label>
    <input type="text" placeholder="Last Name" name="last_name">
  </div>

  <div class="form-input">
    <label for="expiry_date">Expiry Date</label>
    <input type="date" name="expiry_date" value="<?= date('Y-m-d', strtotime("+1 year")); ?>">
  </div>

  <input class="btn" type="submit" name="add" value="Add">
  <button class="btn" id="cancel-add-member" name="cancel">Cancel</button>
</form>