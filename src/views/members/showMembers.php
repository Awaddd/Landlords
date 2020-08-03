<?php 
$array = array(); 

foreach ($data["members"] as $member): 
  if($data["members"]) {
    $date = new DateTime($member->expiry_date);
  } ?>

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