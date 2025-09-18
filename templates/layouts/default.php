<!DOCTYPE html>
<html lang="en">
<?php $this->insert('partials/head', [
    'title' => $title,
    'withNavbar' => true,
    'withSearch' => $withSearch ?? false,
    'withReviews' => $withReviews ?? false,
    'withCaptcha' => $withCaptcha ?? false,
])
?>
<body>
    <?php $this->insert('partials/navbar') ?>
    <?=$this->section('content')?>
    <?php $this->insert('partials/footer') ?>
</body>
</html>
