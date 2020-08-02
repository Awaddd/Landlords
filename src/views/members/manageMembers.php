<?php require_once APPROOT . '/views/inc/header.php'; ?>

<section class="app-manage-members">
  
  <h1>Hi <?= $data["user"] ?></h1>
  <h2>Manage Members</h2> 

  <div class="app-members-table">
  <?php 
    $array = array(); 
    foreach ($data["members"] as $member): ?>
      <div class="table-row">
        <p><?= $member->id . ": " . $member->first_name . " " . $member->last_name ?></p>

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

      <h2>Add Member</h2>
      <button class="btn" id="add-member-btn">New</button>
      <br><br>

      <!-- ADD "modal" -->

      <form id="add-member-form" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
        <input type="text" placeholder="First Name" name="first_name">
        <input type="text" placeholder="Last Name" name="last_name">
        <input type="hidden" value="2020-08-06 00:00:00">

        <input class="btn" type="submit" name="submit" value="Add">
        <button class="btn" id="cancel-edit-member" name="cancel">Cancel</button>
      </form>

      <!-- Edit "modal" -->

      <?php 
        if (isset($_POST['openEdit'])) : 
          $i = $_POST['edit_index']; ?>

          <form class="edit" id="edit-member-form" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
            <input type="text" placeholder="First Name" name="first_name" value="<?= $array[$i]->first_name ?>">
            <input type="text" placeholder="Last Name" name="last_name" value="<?= $array[$i]->last_name ?>">
            <input name="edit_id" type="hidden" value="<?= $array[$i]->id ?>">

            <input class="btn" type="submit" name="edit" value="Update">
            <button class="btn" id="cancel-edit-member" name="cancel">Cancel</button>
          </form>
      <?php endif; ?>

</section>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>