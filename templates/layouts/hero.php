<!DOCTYPE html>
<html lang="en">
<?php $this->insert('partials/head', [
    'title' => $title,
    'withNavbar' => $withNavbar ?? false,
]) ?>

<body>
    <div class="hero is-fullheight">
        <?php if ($withNavbar ?? false): ?>
            <div class="hero-head">
                <?php $this->insert('partials/navbar') ?>
            </div>
        <?php endif ?>
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="columns is-centered">
                    <div class="column is-narrow">
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
