<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/nav.php'; ?>

<section class="app-manage-members">
  <h2 class="page-title">Manage Members</h2> 
  
  <div class="app-members-table">
    <div class="table-row">
      <p class="table-head table-column">ID</p>
      <p class="table-head table-column">First name</p>
      <p class="table-head table-column">Last name</p>
      <p class="table-head table-column">Expiry Date</p>
    </div>
    
    <!-- show members -->
    <?php require_once APPROOT . '/views/members/showMembers.php'; ?>

  </div>

  <div class="form-actions">
    <button class="btn" id="add-member-btn">New</button>
    <!-- ADD -->
    <?php require_once APPROOT . '/views/members/addMembers.php'; ?>

    <!-- Edit -->
    <?php require_once APPROOT . '/views/members/editMembers.php'; ?>
  </div>

</section>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>