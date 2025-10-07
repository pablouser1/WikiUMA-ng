<!DOCTYPE html>
<html lang="es" data-theme="<?= $this->theme() ?>">
<?php $this->insert('partials/head', [
    'title' => $title,
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
