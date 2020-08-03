<?php require_once APPROOT . '/views/inc/header.php'; ?>

<section class="app-manage-members">
  <h2 class="page-title">Manage Members</h2> 
  
  <div class="app-members-table">
    <div class="table-row">
      <p class="table-head table-column">ID</p>
      <p class="table-head table-column">First name</p>
      <p class="table-head table-column">Last name</p>
      <p class="table-head table-column">Expiry Date</p>
    </div>
  <?php 
    $array = array(); 
    foreach ($data["members"] as $member): ?>
      <?php if($data["members"]): ?>
      <?php $date = new DateTime($member->expiry_date); ?>
      <?php endif; ?>
      <div class="table-row">
      
        <p class="table-column"><?= $member->id ?></p>
        <p class="table-column"><?= $member->first_name ?></p>
        <p class="table-column"><?= $member->last_name ?></p>
        <p class="table-column"><?= $date->format('d-m-Y') ?></p>

        <div class="table-actions">

          <?php 
            array_push($array, $member);
            $currentIndex = array_search($member, $array);
          ?>
          <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
            <input name="edit_index" type="hidden" value="<?= $currentIndex ?>">
            <input class="btn" type="submit" name="openEdit" value="Edit">
          </form>

          <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
            <input name="delete_id" type="hidden" value="<?= $member->id ?>">
            <input class="btn" type="submit" name="delete" value="Delete">
          </form>

        </div>
      </div>
    
    <?php endforeach; ?>
    </div>


<!-- ADD "modal" -->
<?php 
  $date = date('Y-m-d', strtotime("+1 year"));
?>

  <div class="form-actions">
  <button class="btn" id="add-member-btn">New</button>
  <form class="form" id="add-member-form" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
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
      <input type="date" name="expiry_date" value="<?= $date ?>">
    </div>

    <input class="btn" type="submit" name="submit" value="Add">
    <button class="btn" id="cancel-add-member" name="cancel">Cancel</button>
  </form>

  <!-- Edit "modal" -->

  <?php 
    if (isset($_POST['openEdit'])) : 
      $i = $_POST['edit_index']; ?>

      <form class="form" id="edit-member-form" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
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
  </div>

</section>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>