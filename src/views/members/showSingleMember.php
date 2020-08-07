<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/nav.php'; ?>
<?php $date = new DateTime($data['member']->expiry_date); ?>
<section class="app-manage-members">
  <h2 class="page-title">Showing Member: <?= $data['member']->first_name ?></h2> 
  <p>Full name: <?= $data['member']->first_name ?> <?= $data['member']->last_name ?></p>
  <p>Membership expiration date: <?= $date->format('d-m-Y') ?></p>
  <a class="btn" href="<?= URLROOT . "/members/" . $data['member']->id . "/pdf"?>">View PDF</a>
</section>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>