<?php 
if (isset($_POST['openEdit'])) : 
  $i = $_POST['edit_index']; ?>

  <form class="form" id="edit-member-form" method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
    <div class="form-input">
      <label for="first_name">First name</label>
      <input type="text" placeholder="First Name" name="first_name" value="<?= $array[$i]->first_name ?>">
    </div>

    <div class="form-input">
      <label for="last_name">Last name</label>
      <input type="text" placeholder="Last Name" name="last_name" value="<?= $array[$i]->last_name ?>">
    </div>
    
    <div class="form-input">
      <label for="expiry_date">Expiry Date</label>
      <input type="date" name="expiry_date" value="<?= $array[$i]->expiry_date ?>">
    </div>

    <input name="edit_id" type="hidden" value="<?= $array[$i]->id ?>">
    <input class="btn" type="submit" name="edit" value="Update">
    <button class="btn" id="cancel-edit-member" name="cancel">Cancel</button>
  </form>
<?php endif; ?>