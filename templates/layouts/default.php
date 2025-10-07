<!DOCTYPE html>
<html lang="en">
<?php $this->insert('partials/head', [
    'title' => $title,
    'withNavbar' => true,
    'withSearch' => $withSearch ?? false,
    'withMaxChars' => $withMaxChars ?? false,
    'withCaptcha' => $withCaptcha ?? false,
    'withReviews' => $withReviews ?? false,
])
?>
<body>
    <?php $this->insert('partials/navbar') ?>
    <?=$this->section('content')?>
    <?php $this->insert('partials/footer') ?>
</body>
</html>
