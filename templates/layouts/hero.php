<!DOCTYPE html>
<html lang="es" data-theme="<?= $this->theme() ?>">
<?php $this->insert('partials/head', [
    'title' => $title,
    'uri' => $uri,
    'withReviews' => $withReviews ?? false,
    'withForm' => $withForm ?? false,
    'withCaptcha' => $withCaptcha ?? false,
]) ?>

<body>
    <div class="hero is-fullheight">
        <div class="hero-head">
            <?php $this->insert('partials/navbar') ?>
        </div>
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column is-narrow" style="max-width: 100%;">
                        <?=$this->section('content')?>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-foot">
            <?php $this->insert('partials/footer') ?>
        </div>
    </div>
</body>
</html>
