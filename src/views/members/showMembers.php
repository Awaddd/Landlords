<?php 
$array = array(); 


for ($i = $_SESSION['firstRow']; $i < $_SESSION['lastRow']; $i++) :   
  
  if($data["members"]) {
    $member = $data['members'][$i];
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
      <form method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
        <input name="edit_index" type="hidden" value="<?= $currentIndex ?>">
        <input class="btn" type="submit" name="openEdit" value="Edit">
      </form>

      <form method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
        <input name="delete_id" type="hidden" value="<?= $member->id ?>">
        <input class="btn" type="submit" name="delete" value="Delete">
      </form>

    </div>
  </div>

<?php endfor; ?>

  <form method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
    <input class="btn" type="submit" value="Previous" name="prev_page">
  </form>
  <form method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
    <input class="btn" type="submit" value="Next" name="next_page">
  </form>