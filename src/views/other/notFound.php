<?php require_once APPROOT . '/views/inc/header.php'; ?>

<?php

if (!isset($data['message'])) : ?>
<p>PAGE NOT FOUND</p>
<?php else: ?>
<p><?= $data['message'] ?></p>
<?php endif; ?>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
